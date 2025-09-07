const API_URL = "https://api.siputzx.my.id/api/tools/ngl";
    
    // DOM Elements
    const startBtn = document.getElementById("startBtn");
    const btnText = document.getElementById("btnText");
    const linkInput = document.getElementById("nglLink");
    const messageInput = document.getElementById("messageText");
    const countInput = document.getElementById("reqCount");
    const delayInput = document.getElementById("reqDelay");
    const charCount = document.getElementById("charCount");
    const messagePreview = document.getElementById("messagePreview");
    const previewText = document.getElementById("previewText");
    const progressSection = document.getElementById("progressSection");
    const progressBar = document.getElementById("progressBar");
    const progressText = document.getElementById("progressText");
    const progressPercentage = document.getElementById("progressPercentage");
    const successCount = document.getElementById("successCount");
    const failCount = document.getElementById("failCount");
    const lastStatus = document.getElementById("lastStatus");
    const errorSection = document.getElementById("errorSection");
    const errorText = document.getElementById("errorText");

    let isRunning = false;

    // Character counter and preview
    messageInput.addEventListener("input", (e) => {
      const text = e.target.value;
      const length = text.length;
      
      charCount.textContent = length;
      charCount.parentElement.classList.toggle("text-red-400", length > 500);
      
      if (text.trim()) {
        previewText.textContent = text;
        messagePreview.classList.remove("hidden");
      } else {
        messagePreview.classList.add("hidden");
      }
    });

    async function delay(ms) {
      return new Promise(resolve => setTimeout(resolve, ms));
    }

    function updateProgress(current, total, success, failed) {
      const percentage = Math.round((current / total) * 100);
      
      progressText.textContent = `${current} / ${total}`;
      progressPercentage.textContent = `${percentage}%`;
      successCount.textContent = success;
      failCount.textContent = failed;
      progressBar.style.width = `${percentage}%`;
    }

    function showError(message) {
      errorText.textContent = message;
      errorSection.classList.remove("hidden");
      setTimeout(() => {
        errorSection.classList.add("hidden");
      }, 5000);
    }

    function setButtonState(loading) {
      if (loading) {
        startBtn.disabled = true;
        btnText.innerHTML = `
          <svg class="animate-spin w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
          Mengirim Pesan...
        `;
      } else {
        startBtn.disabled = false;
        btnText.innerHTML = `
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
          </svg>
          Kirim Pesan Bulk
        `;
      }
    }

    startBtn.addEventListener("click", async () => {
      if (isRunning) return;
      
      const link = linkInput.value.trim();
      const message = messageInput.value.trim();
      const total = parseInt(countInput.value, 10);
      const delayMs = parseInt(delayInput.value, 10);

      // Validation
      if (!link || !link.includes("ngl.link/")) {
        showError("Masukkan link NGL yang valid! (contoh: https://ngl.link/username)");
        return;
      }
      if (!message) {
        showError("Pesan tidak boleh kosong!");
        return;
      }
      if (message.length > 500) {
        showError("Pesan terlalu panjang! Maksimal 500 karakter");
        return;
      }
      if (total < 1 || total > 100) {
        showError("Jumlah pengiriman harus antara 1-100");
        return;
      }
      if (delayMs < 500) {
        showError("Delay minimal 500ms untuk menghindari rate limiting");
        return;
      }

      // Start process
      isRunning = true;
      setButtonState(true);
      errorSection.classList.add("hidden");
      progressSection.classList.remove("hidden");
      
      let success = 0;
      let failed = 0;
      updateProgress(0, total, 0, 0);
      lastStatus.textContent = "Memulai pengiriman...";

      for (let i = 1; i <= total; i++) {
        try {
          const url = `${API_URL}?link=${encodeURIComponent(link)}&text=${encodeURIComponent(message)}`;
          const response = await fetch(url);
          const data = await response.json();

          if (data.status === true) {
            success++;
            lastStatus.textContent = `✅ Pesan ${i} berhasil dikirim`;
            if (data.data?.questionId) {
              lastStatus.textContent += ` (ID: ${data.data.questionId})`;
            }
          } else {
            failed++;
            lastStatus.textContent = `❌ Pesan ${i} gagal: ${data.message || "Unknown error"}`;
          }
        } catch (error) {
          failed++;
          lastStatus.textContent = `❌ Pesan ${i} error: ${error.message}`;
        }

        updateProgress(i, total, success, failed);
        
        if (i < total) {
          lastStatus.textContent += ` | Menunggu ${delayMs}ms...`;
          await delay(delayMs);
        }
      }

      // Finish
      isRunning = false;
      setButtonState(false);
      
      // Show completion message
      setTimeout(() => {
        const successRate = Math.round((success / total) * 100);
        lastStatus.textContent = `🎉 Pengiriman selesai! ${success}/${total} berhasil (${successRate}%)`;
      }, 500);
    });

    // Input validation
    countInput.addEventListener("input", (e) => {
      const value = parseInt(e.target.value);
      if (value > 100) {
        e.target.value = 100;
        showError("Maksimal 100 pesan per sesi untuk mencegah spam");
      }
      e.target.classList.toggle("border-red-400", value < 1 || value > 100);
    });

    delayInput.addEventListener("input", (e) => {
      const value = parseInt(e.target.value);
      if (value < 500) {
        e.target.value = 500;
      }
      e.target.classList.toggle("border-red-400", value < 500);
    });

    linkInput.addEventListener("input", (e) => {
      e.target.classList.toggle("border-red-400", !e.target.value.includes("ngl.link/"));
    });
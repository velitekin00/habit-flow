let weeklyChart = null;

// ===============================
// AJAX TAMAMLANDI / TAMAMLANMADI
// ===============================

document.querySelectorAll(".ajax-toggle-form").forEach(function (form) {

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const formData = new FormData(form);
        const actionUrl = form.getAttribute("action");

        const button = form.querySelector(".check-btn");
        const habitItem = form.closest(".habit-item");

        if (!button || !habitItem) {
            return;
        }

        button.disabled = true;
        button.classList.add("loading");

        fetch(actionUrl, {
            method: "POST",
            body: formData
        })
            .then(function (response) {
                return response.json();
            })
            .then(function (data) {

                if (!data.success) {
                    alert("İşlem başarısız oldu.");
                    return;
                }

                if (data.is_completed == 1) {
                    button.classList.add("active");
                } else {
                    button.classList.remove("active");
                }

                const progressText = habitItem.querySelector(".habit-progress-text");
                const progressBar = habitItem.querySelector(".habit-progress-bar");

                if (progressText && progressBar) {
                    if (data.is_completed == 1) {
                        progressText.textContent = data.target_value + " / " + data.target_value + " " + data.unit;
                        progressBar.style.width = "100%";
                    } else {
                        progressText.textContent = "0 / " + data.target_value + " " + data.unit;
                        progressBar.style.width = "0%";
                    }
                }

                const dailyRate = document.getElementById("dailyRate");
                const dailyProgressBar = document.getElementById("dailyProgressBar");
                const dailyCompletedText = document.getElementById("dailyCompletedText");

                if (dailyRate) {
                    dailyRate.textContent = "%" + data.completionRate;
                }

                if (dailyProgressBar) {
                    dailyProgressBar.style.width = data.completionRate + "%";
                }

                if (dailyCompletedText) {
                    dailyCompletedText.textContent = data.completedHabits + " / " + data.totalHabits + " tamamlandı";
                }

                /*
                    Grafik varsa bugünkü oranı anlık güncelle.
                */

                if (weeklyChart && weeklyChart.data.datasets[0]) {
                    const lastIndex = weeklyChart.data.datasets[0].data.length - 1;

                    weeklyChart.data.datasets[0].data[lastIndex] = data.completionRate;
                    weeklyChart.update();
                }

            })
            .catch(function (error) {
                console.error("AJAX hata:", error);
                alert("Bir hata oluştu.");
            })
            .finally(function () {
                button.disabled = false;
                button.classList.remove("loading");
            });

    });

});


// ===============================
// HAFTALIK GRAFİK
// ===============================

const weeklyChartElement = document.getElementById("weeklyChart");

if (
    weeklyChartElement &&
    typeof Chart !== "undefined" &&
    typeof weeklyLabels !== "undefined" &&
    typeof weeklyRates !== "undefined"
) {
    weeklyChart = new Chart(weeklyChartElement, {
        type: "bar",
        data: {
            labels: weeklyLabels,
            datasets: [
                {
                    label: "Tamamlama Oranı",
                    data: weeklyRates,
                    backgroundColor: "#2563eb",
                    borderRadius: 8,
                    barThickness: 16,
                    maxBarThickness: 20
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,

            plugins: {
                legend: {
                    display: false
                },

                tooltip: {
                    callbacks: {
                        label: function (context) {
                            return "%" + context.raw + " tamamlandı";
                        }
                    }
                }
            },

            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    ticks: {
                        stepSize: 25,
                        callback: function (value) {
                            return "%" + value;
                        }
                    },
                    grid: {
                        color: "#e5e7eb"
                    }
                },

                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
}
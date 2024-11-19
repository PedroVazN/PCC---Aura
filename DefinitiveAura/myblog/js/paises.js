document.addEventListener("DOMContentLoaded", function () {
    const input = document.querySelector("#phone");

    // Inicializa o intl-tel-input
    const iti = window.intlTelInput(input, {
        initialCountry: "auto",
        geoIpLookup: function (success) {
            fetch("https://ipinfo.io/json?token=your_api_token_here") // Use o token válido de ipinfo.io
                .then((resp) => resp.json())
                .then((data) => success(data.country))
                .catch(() => success("US"));
        },
        utilsScript:
            "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js",
    });

    const form = document.querySelector("#registration-form");

    form.addEventListener("submit", (e) => {
        const fullNumber = iti.getNumber(); // Número completo com código DDI
        input.value = fullNumber; // Atualiza o valor no formulário
    });
});

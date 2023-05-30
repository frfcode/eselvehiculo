let getButtonsEmotional = document.querySelectorAll("#emotional_status");
if (getButtonsEmotional.length >= 0) {
    let getBoxPhraseDay = document.getElementById("phrase_day");
    let randomNumber = Math.floor(
        Math.random() * (getButtonsEmotional.length - 0) + 0
    );
    getButtonsEmotional.forEach((button) => {
        button.addEventListener("click", () => {
            getBoxPhraseDay.innerHTML = "";
            if (button.value == "happy") {
                fetchData(`${window.location.origin}/json/happy.json`).then(
                    (data) => {
                        console.log(data);
                        getBoxPhraseDay.innerHTML = `<p class="text-center fs-4 bg-dark text-white p-2">${data[randomNumber].phrase}</p>`;
                    }
                );
            }
            if (button.value == "sad") {
                fetchData(`${window.location.origin}/json/sad.json`).then(
                    (data) => {
                        getBoxPhraseDay.innerHTML = `<p class="text-center fs-4 bg-dark text-white p-2">${data[randomNumber].phrase}</p>`;
                    }
                );
            }
        });
    });
}

async function fetchData(url) {
    let data = await fetch(url);
    let response = data.json();
    return response;
}

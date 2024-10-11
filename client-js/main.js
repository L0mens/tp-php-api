const messageDiv = document.getElementById("message");

async function afficherMessage() {
    const reponse = await fetch("http://localhost/tp-php-api/src/index.php?service=ping",{
        mode: "cors"
    });
    console.log(reponse);
    const ping = await reponse.json();
    console.log(ping);
    messageDiv.innerHTML = ping.ping;
}

afficherMessage();
const objectif = 1000;

async function loadDonations(){
const res = await fetch("api/get-donations.php");
const data = await res.json();

let total = 0;
let html = "";

data.reverse().forEach(d => {
total += Number(d.amount);
html += `<p><b>${d.name}</b> - ${d.amount}€ <br>${d.message}</p>`;
});

document.getElementById("donations").innerHTML = html;

document.getElementById("total").innerText = total + "€ / 1000€";

document.getElementById("bar").style.width = (total / objectif * 100) + "%";
}

async function donate(){
const name = document.getElementById("name").value;
const amount = document.getElementById("amount").value;
const message = document.getElementById("message").value;

await fetch("api/donate.php", {
method:"POST",
headers:{"Content-Type":"application/json"},
body:JSON.stringify({name,amount,message})
});

loadDonations();
}

loadDonations();

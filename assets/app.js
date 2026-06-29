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

const objectif = 1000;

async function loadDonations(){
const res = await fetch("api/get-donations.php");
const data = await res.json();

let total = 0;

// 🔥 TRI POUR LE CLASSEMENT
const sorted = [...data].sort((a,b)=> b.amount - a.amount);

let html = "";
let rank = 1;

sorted.forEach(d => {
total += Number(d.amount);

let medal = "";
if(rank === 1) medal = "👑";
else if(rank === 2) medal = "🥈";
else if(rank === 3) medal = "🥉";

html += `
<p>
<b>${medal} ${rank}. ${d.name}</b><br>
${d.amount}€<br>
<small>${d.message || ""}</small>
</p>
`;

rank++;
});

document.getElementById("donations").innerHTML = html;

document.getElementById("total").innerText = total + "€ / 1000€";

let percent = (total / objectif) * 100;
document.getElementById("bar").style.width = percent + "%";

// 🎉 trigger confettis
if(total >= objectif){
launchConfetti();
}
}

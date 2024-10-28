const curiosidades = [{
    text: "O estudo é focado em aprender uma profissão",
    img: "images/curiosidade1.jpg"
},
{
    text: "O SENAI qualifica milhões de trabalhadores por ano, sendo o maior complexo de educação profissional da América Latina.",
    img: "images/curisiodade2.png"
},
{
    text: "Ser capacitado para o mercado de trabalho: cursos voltados para as demandas do mercado.",
    img: "images/curisiodade3.png"
},
{
    text: "Poder fazer um curso a distância de qualidade: mais de 300 cursos EAD.",
    img: "images/curisiodade4.png"
},
{
    text: "Professores qualificados e atualizados com o mercado de trabalho.",
    img: "images/curisiodade5.png"
},
{
    text: "Tem sempre uma unidade perto de você: SENAI está em 2.700 municípios no Brasil.",
    img: "images/curisiodade6.png"
},
{
    text: "Opções de cursos para todas as fases da vida: qualificação profissional, técnico, graduação e mais.",
    img: "images/curisiodade7.png"
}
];

let currentCuriosidade = 0;

const imgElement = document.getElementById("curiosidade-img");
const textElement = document.getElementById("curiosidade-text");

document.getElementById("prevBtn").onclick = () => {
currentCuriosidade = (currentCuriosidade - 1 + curiosidades.length) % curiosidades.length;
updateCuriosidade();
};

document.getElementById("nextBtn").onclick = () => {
currentCuriosidade = (currentCuriosidade + 1) % curiosidades.length;
updateCuriosidade();
};

function updateCuriosidade() {
imgElement.src = curiosidades[currentCuriosidade].img;
textElement.textContent = curiosidades[currentCuriosidade].text;
}
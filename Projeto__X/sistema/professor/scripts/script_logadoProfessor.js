/* global divCriar, divContent, title */

window.onload = function(){
    divContent = document.getElementById('content');
    divCriar = document.getElementById('criar');
    title = document.getElementById('title');
    divCriar.style.display = 'none';
    
};

function criarDiv(){
    title.innerHTML = 'Criar Curso';
    divContent.style.display = 'none';
    divCriar.style.display = 'block';
}

function contentDiv(){
    title.innerHTML = 'Meus cursos';
    divContent.style.display = 'block';
    divCriar.style.display = 'none';
}

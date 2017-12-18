/* global divCriar, divContent, title,array, divForum */

window.onload = function(){
    divContent = document.getElementById('content');
    divCriar = document.getElementById('criar');
    divForum = document.getElementById('forum');
    title = document.getElementById('title');
    divCriar.style.display = 'none';
      
};

function criarDiv(){
    title.innerHTML = 'Criar Curso';
    divContent.style.display = 'none';
    divForum.style.display = 'none';
    divCriar.style.display = 'block';
}

function contentDiv(){
    title.innerHTML = 'Meus cursos';
    divCriar.style.display = 'none';
    divForum.style.display = 'none';
    divContent.style.display = 'block';
}

function forumDiv(){
    title.innerHTML = 'Fórum';
    divCriar.style.display = 'none';
    divContent.style.display = 'none';
    divForum.style.display = 'block';
}

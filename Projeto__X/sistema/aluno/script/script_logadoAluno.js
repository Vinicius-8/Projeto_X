/* global  title,array, divForum, divCurso */

window.onload = function(){
    divCurso = document.getElementById('cursos');
    divForum = document.getElementById('forum');
    title = document.getElementById('title');
    divCurso.style.display = 'none';
      
};

function cursosDiv(){
    title.innerHTML = 'Meus Cursos';
    divForum.style.display = 'none';
    divCurso.style.display = 'block';
}


function forumDiv(){
    title.innerHTML = 'Fórum';
    divCurso.style.display = 'none';
    divForum.style.display = 'block';
}

tinymce.init({
    selector: '#content'
});

tinymce.init({
    selector: '#excerpt'
});


let alertaEditado = document.querySelector('#info')
if(alertaEditado){
    setTimeout(() => {
        alertaEditado.style.display="none";
        var cleanURL = window.location.origin+window.location.pathname
        window.location.href = cleanURL;
    }, 5000 );
}

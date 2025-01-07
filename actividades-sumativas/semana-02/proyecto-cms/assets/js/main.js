tinymce.init({
    selector: '#content'
});

tinymce.init({
    selector: '#excerpt'
});

let alertaEditado = document.querySelector('.alert-primary')
if(alertaEditado){
    setTimeout(() => {
        alertaEditado.style.display="none";
    }, 3000);
}

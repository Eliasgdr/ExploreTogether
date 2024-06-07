function redirectMessages() {
    window.location.replace('./messages.php');
}

document.addEventListener('DOMContentLoaded', () => {
    const openDivButton = document.getElementById('searchUsr');
    const closeDivButton = document.querySelector('.close'); 
    const threadContainer = document.querySelector('.container');
    const addUsrSearch = document.querySelector('.addUsrSearch');

    function disableBodyScroll() {
        document.body.classList.add('no-scroll');
        threadContainer.setAttribute('noClick', '');
        addUsrSearch.style.display = 'grid'; 
    }

    function enableBodyScroll() {
        document.body.classList.remove('no-scroll');
        threadContainer.removeAttribute('noClick', '');
        addUsrSearch.style.display = 'none'; 
    }

    openDivButton.addEventListener('click', disableBodyScroll);
    closeDivButton.addEventListener('click', enableBodyScroll);
});

document.addEventListener('DOMContentLoaded', () => {
    const openDivButton = document.getElementById('imgReport');
    const closeDivButton = document.getElementById('close'); 
    const threadContainer = document.querySelector('.container');
    const addUsrSearch = document.querySelector('.reportUsr');

    function disableBodyScroll() {
        document.body.classList.add('no-scroll');
        threadContainer.setAttribute('noClick', '');
        addUsrSearch.style.display = 'grid'; 
    }

    function enableBodyScroll() {
        document.body.classList.remove('no-scroll');
        threadContainer.removeAttribute('noClick', '');
        addUsrSearch.style.display = 'none'; 
    }

    openDivButton.addEventListener('click', disableBodyScroll);
    closeDivButton.addEventListener('click', enableBodyScroll);
});
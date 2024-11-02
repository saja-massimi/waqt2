<script>

function toggleSidenav() {
    const sidenav = document.getElementById('sidenav-main');
    const isVisible = sidenav.style.transform === 'translateX(0rem)';

    sidenav.style.transform = isVisible ? 'translateX(-17.125rem)' : 'translateX(0rem)';

    if (isVisible) {
        sidenav.classList.remove('bg-white');
    } else {
        sidenav.classList.add('bg-white');
    }
}


</script>



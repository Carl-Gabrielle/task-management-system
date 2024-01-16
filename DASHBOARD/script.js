

function hideSidebar(){
        const sidebar = document.getElementById('sidebar'); 
        sidebar.style.display ='none';
            window.addEventListener('scroll', function() {
                if (window.scrollY > 100) {
                showSidebar();
                }
            });
}
function showSidebar(){
    const sidebar = document.getElementById('sidebar');
    sidebar.style.display ='block';
}
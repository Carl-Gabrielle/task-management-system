     
                    // document.addEventListener('DOMContentLoaded', function() {
                    //     document.getElementById('toggleSidebar').addEventListener('click', function() {
                    //         document.getElementById('sidebar').classList.toggle('hide');
                    //     });
                    // });
                    // SIDEBAR DROPDOWN
                    const allDropdown =document.querySelectorAll('#sidebar .side-dropdown');
                    allDropdown.forEach(item => {
                        const a= item.parentElement.querySelector('a:first-child');
                        a.addEventListener('click', function(e){
                            e.preventDefault();
                            if(!this.classList.contains('active')){
                                allDropdown.forEach(i =>{
                                    const aLink= i.parentElement.querySelector('a:first-child');
                                    aLink.classList.remove('active');
                                i.classList.remove('show');
                                })
                            }
                            this.classList.toggle('active');
                            item.classList.toggle('show');
                        })
                    });
                    //  PROFILE DROPDOWN
                    const profile = document.querySelector('nav .profile');
                    const imgProfile = profile.querySelector('img');
                    const dropdownProfile = profile.querySelector('.profile-link');
                    imgProfile.addEventListener('click', function(){
                        dropdownProfile.classList.toggle('show');
                    })
                    window.addEventListener('click', function (e){
                        if (e.target !== imgProfile){
                            if (e.target !== dropdownProfile){
                                if (dropdownProfile.classList.contains('show')){
                                    dropdownProfile.classList.remove('show');
                                }
                            }
                        }
                    })
                    // <!-- SIDEBAR COLLAPSE -->
                    const toggleSidebar = document.querySelector(' .toggle-sidebar');
                    const content = document.getElementById('content');
                    const sidebar =document.getElementById('sidebar');
                    const allSideDivider = document.querySelectorAll('#sidebar .divider');
                    toggleSidebar.addEventListener('click', function (){
                        sidebar.classList.toggle('hide');
                        if (sidebar.classList.contains('hide')){
                            allSideDivider.forEach(item=>{
                                item.textContent = "-"
                            })
                        }else {
                            allSideDivider.forEach(item=>{
                                item.textContent = item.dataset.text;
                            })
                        }
                    })
                  
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-...." crossorigin="anonymous">
        <title>Document</title>
    </head>
    <style>
        /* #popup-modal .bg-white {
    background-color: rgba(255, 255, 255,0.1);
    backdrop-filter: blur(8px);
    border:none;
    } */
    #popup-modal .bg-white {
    background-color: rgba(255, 255, 255,0.1);
    backdrop-filter: blur(3px);
    border: 1px solid #ccc;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    background: linear-gradient(to right, #fff 0%, #fff 50%, #eee 100%);
    text-align: center;
    }
    #popup-modal, #btn_modal {
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}
    </style>
    <body>
    <button class="transition transform hover:-translate-y-1 motion-reduce:transition-none motion-reduce:hover:transform-none ...">
  Hover me
</button>
    <button id ="btn_modal" data-modal-target="popup-modal" data-modal-toggle="popup-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
    Toggle modal
    </button>

    <div id="popup-modal" tabindex="-1" class="fixed z-50 hidden p-4 overflow-x-hidden overflow-y-auto inset-0 max-h-full flex items-center justify-center">
    <div class="bg-white text rounded-lg shadow dark:bg-gray-700 max-w-md w-full">
        <!-- Remove the button and unnecessary elements for responsiveness -->
        <div class="p-6 text-center">
            <svg class="mx-auto mb-4 text-green-500 w-12 h-12 dark:text-green-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"></circle>
                <path stroke="currentColor" stroke-width="2" d="M9 12l2 2 4-4"></path>
            </svg>
            <h3 class="font-bold text-black animate-bounce" style="font-size: 1.5rem;">Awesome!</h3>
            <h3 class="mb-5 text-lg text-gray-700 dark:text-gray-300" style="font-family:'Roboto', sans-serif">You have successfully registered with TaskWind!</h3>
            <button name="login_btn" type="submit" data-modal-hide="popup-modal" class="bg-gray-800 text-white w-full font-semibold hover:bg-gray-700 py-2 px-4 rounded-md transition duration-200">
                Proceed to Log In <i class="fa-solid fa-right-to-bracket pl-2" style="color: #ffffff;"></i>
            </button>
        </div>
    </div>
</div>



    <script>
        const modalTrigger = document.querySelector('[data-modal-toggle="popup-modal"]');
        const modal = document.getElementById('popup-modal');
        const modalClose = document.querySelector('[data-modal-hide="popup-modal"]');
        
        modalTrigger.addEventListener('click', () => {
            modal.classList.remove('hidden');
        });

        modalClose.addEventListener('click', () => {
            modal.classList.add('hidden');
        }); 
        const yes_Button = document.getElementById('login_Btn')
            yes_Button.addEventListener('click', () =>{
                modal.classList.add('hidden');
            })

        // const cancelButton = document.getElementById('close');
        // cancelButton.addEventListener('click', () => {
        //     modal.classList.add('hidden');
        // });

    </script>

    </body>
    </html>

require('./bootstrap');
require('./vue');




let custom_file_inputs = document.querySelectorAll('.custom-file-input');

for(let i = 0; i < custom_file_inputs.length; i++) {
    custom_file_inputs[i].addEventListener('change',function(e){
        if(this.files[0]) {
            let fileName = this.files[0].name;
            let nextSibling = e.target.nextElementSibling;
            nextSibling.innerText = fileName;
        }

    });
}
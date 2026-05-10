import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM is ready, jQuery available as window.$');

    function fetchStudents() {
        $.get('/studentss', function(data){
            console.log(data);
            $('#students-list').html(data);
        })
    }

    setInterval(function() {
        fetchStudents();
    }, 1000);

});

Alpine.start();

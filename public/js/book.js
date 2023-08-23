var pathname = $(location).attr('pathname');
var bookIdPosition = pathname.lastIndexOf('/') + 1;
var isBookInUse = false;
var bookId;

// doAjaxQuery('GET', '/api/v1/books/' + pathname.substr(bookIdPosition), null, function(res) {
//     view.fillBookInfo(res.data);
//     if (res.data.event) {
//         isBookInUse = true;
//         bookId = res.data.id;
//     }
// });

/* --------------------Show the result, for sending the -----------------------
----------------------email in the queue for the book ---------------------- */
// var showResultSendEmailToQueue = function(email, result) {
//     var busy = $('#bookID').attr('busy');
//     $('.form-queue', '.btnBookID', (busy === null) ? '.freeBook' : '.busyBook').css('display', 'none');
//     $('.response').css('display', 'block');
//     $('span.youEmail').text(' ' + email);
// };

/*--------------- Send email. Get in Queue in for a book ---------------------*/
// var sendEmailToQueue = function(id, email) {
//     doAjaxQuery('GET', '/api/v1/books/' + id + '/order?email=' + email, null, function(res) {
//         showResultSendEmailToQueue(email, res.success);
//     });
// };

/* --------------- Checking validity of email when typing in input -----------*/
// $('.orderEmail').keyup(function(event) {
//     var email = $(this).val();
//     var isEmail = controller.validateEmail(email);
//     if (email === '') {
//         $('.input-group').removeClass('has-error has-success');
//         view.hideElement('.glyphicon-remove', '.glyphicon-ok');
//     } else {
//         if (isEmail) {
//             view.showSuccessEmail();
//             if (event.keyCode == 13) {
//
//                 var id = $('#bookID').attr('book-id');
//                 sendEmailToQueue(id, email);
//             }
//         } else {
//             view.showErrEmail();
//         }
//     }
// });
/*------------------ Sending email by clicking on the button ----------------*/

//працює?

// $(document).ready(function() {
//     $('.details').click(function() {
//         let bookId = $(this).data('book-id'); // Отримання ID книги з атрибуту data

//         $.ajax({
//             url: '/ajax/views-count/' + bookId,
//             method: 'GET',
//             success: function(response) {
//                 let newViewsCount = parseInt(response);
//                 // Оновити лічильник переглядів на сторінці
//                 $('#viewsCounter').text(newViewsCount);
//             }
//         });
//     });
// });

$(document).ready(function() {
    let bookId = $("#id").attr("book-id");

    $.ajax({
        url: '/counter/', 
        method: 'POST',
        data: {
            "counter-type": "views",
            "id": bookId
        },

        success: function(response) {
            let newViewsCounter = parseInt(response);
            $('#viewsCounter').text(newViewsCounter);
        }
    });
});

$('.btnBookID').click(function(event) {
    event.preventDefault();
    
    let bookId = $(this).data('book-id'); 
    
    $.ajax({
        url: '/counter/', 
        method: 'POST',
        data: {
            "counter-type": "wants",
            "id": bookId
        },
        
        success: function(response) {
            let newWantsCounter = parseInt(response);
            $('#wantsCounter').text(newWantsCounter);

            alert(
                "Книга свободна и ты можешь прийти за ней." +
                " Наш адрес: г. Кропивницкий, переулок Васильевский 10, 5 этаж." +
                " Лучше предварительно прозвонить и предупредить нас, чтоб " +
                " не попасть в неловкую ситуацию. Тел. 099 196 24 69"
            );
        }
    });
});


//after success
    // var email = $('.orderEmail').val();
    // var isEmail = controller.validateEmail(email);
    // if (isEmail) {
    //     view.showSuccessEmail();
    //     var id = $('#bookID').attr('book-id');
    //     sendEmailToQueue(id, email);
    // } else {
    //     view.showErrEmail();
    // }
    // if (isBookInUse) {
    //     view.showSubscribe(
    //         "Сейчас эта книга находится на руках, у одного из наших учеников." +
    //         " Оставь свой email и мы сообщим, как только книга вновь" +
    //         " появится в библиотеке", bookId);
    // } else 

$(document).ready(function(){
    $('#contactForm').on('submit', function(event){
        event.preventDefault(); // Prevent default form submission

        $.ajax({
            url: 'process_form.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response){
                   alert('Form submitted successfully!');
                   $('#contactForm')[0].reset(); // Reset the form
                },
            error: function(xhr, status, error){
                alert('An error occurred')
            }
        });
    });
});
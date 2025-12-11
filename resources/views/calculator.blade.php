<!DOCTYPE html>

<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Инвестиционный калькулятор для расчета суммы инвестирования</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
</head>

<body>

    <div class="container panel panel-default ">
        <h2 class="panel-heading">Laravel Ajax jquery Validation</h2>
        <form id="contactForm">
            <div class="form-group">
                <input type="text" name="name" class="form-control" placeholder="Enter Name" id="name">
            </div>

            <div class="form-group">
                <input disabled type="text" name="email" class="form-control" placeholder="Enter Email" id="email">
            </div>

            <div class="form-group">
                <input type="text" name="mobile_number" class="form-control" placeholder="Enter Mobile Number" id="mobile_number">
            </div>

            <div class="form-group">
                <input type="text" name="subject" class="form-control" placeholder="Enter subject" id="subject">
            </div>

            <div class="form-group"> 
                <textarea class="form-control" name="message" placeholder="Message" id="message"></textarea>
            </div>
            <div class="form-group">
                <button class="btn btn-success" id="submit">Submit</button>
            </div>
        </form>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>

    <script>
        $('#contactForm').on('submit',function(event){
            event.preventDefault();

            let name = $('#name').val();
            let email = $('#email').val();
            let mobile_number = $('#mobile_number').val();
            let subject = $('#subject').val();
            let message = $('#message').val();

            $.ajax({
                url: "/contact-form",
                type:"POST",
                data:{
                    "_token": "{{ csrf_token() }}",
                    name:name,
                    email:email,
                    mobile_number:mobile_number,
                    subject:subject,
                    message:message,
                },
                success:function(response){
                console.log(response);
                },
            });
        });
    </script>
 </body>
</html>
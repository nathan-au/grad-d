<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <style>
        body, html {
            height: 100%;
        }

        .logo {
            position: absolute;
            top: 0;
            right: 0;
            z-index: 1;
        }
    </style>
</head>
<body>
    <?php
    $surround_active = $_GET['id'];

    require("../database.php");
    $query = $pdo->prepare("SELECT * FROM surroundingSlides WHERE surround_active = :surround_active");
    $query->bindParam(":surround_active", $surround_active);
    $query->execute();
    $surroundingSlides = $query->fetchAll(PDO::FETCH_ASSOC);
    ?>

<div id="slideContainer"></div>

    <script>
        var surroundingSlides = <?php echo json_encode($surroundingSlides); ?>;
        var i = 0;

        function updateSlide() {
            var slide = surroundingSlides[i];
            document.getElementById('slideContainer').innerHTML = slide['surround_html'];
        }

        updateSlide();

        document.addEventListener("keydown", function(event) {
            if (event.keyCode === 37) { // left arrow key
                i--;
                if (i < 0) {
                    i = surroundingSlides.length - 1;
                }
            } else if (event.keyCode === 39) { // right arrow key
                i++;
                if (i >= surroundingSlides.length) {
                    i = 0;
                }
            }
            updateSlide();
        });
    </script>
</body>
</html>

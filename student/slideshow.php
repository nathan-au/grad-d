
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <title>Slideshow</title>
    <style>
        @font-face {
            font-family: font_montserrat_light;
            src: url(../images/montserrat_light.ttf);
        }
        body {
            overflow: hidden;
            color: white;
            font-family: font_montserrat_light;
        }
        .red {
            position: absolute;
            background-color: rgb(136, 8, 8);
            width: 20%;
            height: 100%;
            top: 10px;
            z-index: 1;
        }
        .blue {
            position: absolute;
            background-color: #000058;
            height: 90%;
            width: 95%;
            top: 50px;
            left: 3%;
            z-index: 2;
        }
        .content {
            position: absolute;
            top: 130px;
            z-index: 3;
        }
        .logo {
            position: absolute;
            top: 0;
            left: 150px;
            z-index: 3;
            opacity: 0.15;
            filter: sepia(100%) hue-rotate(190deg) saturate(50%);
            transform: rotate(20deg);
            width: 1500px;
            height: 800px;
        }
        .carousel-item {
            /* display: flex; */
            justify-content: center;
            transition: opacity 1s ease-in-out;
            
        }
        .carousel-item img {
            max-height: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    
    <div class="red"></div>
    <div class="blue"></div>

    <img class="logo" src="../images/wcss_logo.png" alt="WCSS logo">

    <div class="content">
        <div style="display: flex;">
            <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="3000" data-bs-wrap="false">
                <div class="carousel-inner" id = "carouselInner">
                    <div class="carousel-item active">
                        <img id = "show_pic0">
                    </div>
                    <div class="carousel-item">
                        <img id = "show_pic1" >
                    </div>
                    <div class="carousel-item">
                        <img id = "show_pic2" >
                    </div>
                    <div class="carousel-item">
                        <img id = "show_pic3">
                    </div>
                    <div class="carousel-item">
                        <img id = "show_pic4">
                    </div>
                </div>
            </div>

            <img name="slide" id = "slide">
            <div style="margin-left: 80px;">
                <div style="position: fixed; top: 50px; right: 40px;">
                    <h1>WEST CARLETON</h1>
                </div>
            
                <div style="position: fixed; top: 100px; right: 40px; font-weight: bold;">
                    <h1 id="show_fname"></h1>
                    <h1 id="show_lname"></h1>
                </div>
                <div style="position: fixed; top: 130px; left: 500px">
                    <h1 id="awards_font"></h1>
                    <ul id="show_awards"></ul>
                    <h1 id="futurePlans_font"></h1>
                    <ul id="show_future_plans"></ul>
                    <h1 id="scholarship_font"></h1>
                    <ul id="show_scholarships"></ul>
                    <h1 id="memMoment_font"></h1>
                    <h4 id="show_mem_moments"></h4>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.carousel').carousel({
                interval: 3000,
                // wrap: false,
                pause: false,
                ride: 'carousel'
            });


        $('.carousel-item').each(function(index){
            varimageSrc = $('#show_pic' +index).attr('src');

            if (!imageSrc){
                $(this).next().addClass('active');
                $(this).remove();
            }
        });
        
    });
    </script>   
</body>
</html>
<style>
    div.style_backgroundDiv{
        background-color: rgb(0, 1, 102);
        opacity: 0.6;
        top:0;
        bottom:0;
        left:0;
        right:0;
        position: absolute;
        z-index: -1;
    }
    img.style_backgroundImg{
        object-fit: cover;
        top:0;
        left:0;
        height:100%;
        width: 100%;
        position: absolute;
        z-index: -2;
    }
    img.style_wcss_logo{
        opacity: 0.2;
        position:absolute;
        width:35%;
        height:auto;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 1;
    }
    h1.style_main_header{
        position:absolute;
        color:white;
        font-family: font_sweet_romance;
        font-size: 10vw;
        text-align:center;
        top: 45%;
        left: 50%;
        transform: translate(-50%, -45%);
        z-index: 2;
    }
    h2.style_secondary_header{
        position:absolute;
        color:white;
        font-family: font_montserrat_light;
        font-size: 2.6vw;
        text-align:center;
        top: 55%;
        left: 50%;
        transform: translate(-50%, -55%);
        z-index: 2;
    }
    div.style_button_div{
        width:10%;
        margin: 0;
        position: absolute;
        bottom: 5%;
        left: 50%;
        transform: translate(-50%, -5%);
        -ms-transform: translate(-50%, -50%);
    }
    button.style_btn_down_arrow{
        width:100%;
        border: none;
        cursor: pointer;
        appearance: none;
        background-color: inherit;
    }
    img.style_down_arrow{
        width:100%;
        height:auto;
    }
</style>

<div class="div_child">
    <div class = "style_backgroundDiv"></div>
    <img class = "style_backgroundImg" src="../images/school_background2.png"> 
    <img class = "style_wcss_logo" src="../images/wcss_concept_white_traced.png">

    <h1 class = "style_main_header">Commencement</h1>
    <h2 class = "style_secondary_header" id = "text_grad_year"></h2>

    <div class = "style_button_div">
        <a href="#href_welcome_banner">
            <button class="style_btn_down_arrow">
                <img class = "style_down_arrow" src="../images/down_arrow.png">
            </button>
        </a>
    </div>
</div>

<script> //UPDATES THE YEAR AUTOMATICALLY
    const d = new Date();
    let year = d.getFullYear();
    document.getElementById('text_grad_year').innerHTML = "— WEST GRADS "+year+" —";
</script>
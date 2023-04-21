<div id="slider" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#slider" data-slide-to="0" class="active"></li>
        <li data-target="#slider" data-slide-to="1"></li>
        <li data-target="#slider" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="https://wowslider.com/sliders/demo-18/data1/images/hongkong1081704.jpg" alt="Slide 1">
            <div class="carousel-caption">
                <h5>Slide 1</h5>
                <p>Some text for slide 1.</p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="https://wowslider.com/sliders/demo-18/data1/images/shanghai.jpg" alt="Slide 2">
            <div class="carousel-caption">
                <h5>Slide 2</h5>
                <p>Some text for slide 2.</p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="https://jssors8.azureedge.net/demos/image-slider/img/faded-monaco-scenery-evening-dark-picjumbo-com-image.jpg" alt="Slide 3">
            <div class="carousel-caption">
                <h5>Slide 3</h5>
                <p>Some text for slide 3.</p>
            </div>
        </div>
    </div>
    <a class="carousel-control-prev" href="#slider" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#slider" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>
<script>
    $(document).ready(function() {
        $('#slider').carousel({
            interval: 1000 // Set the interval time for each slide
        });
    });

</script>


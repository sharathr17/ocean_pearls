     // Hide Loader when page fully loads
     window.addEventListener("load", function() {
        document.querySelector(".loader-wrapper").style.opacity = "0";
        setTimeout(() => document.querySelector(".loader-wrapper").style.display = "none", 1500);
    });

    // Image Loading with Spinner
    document.querySelectorAll(".image-loader img").forEach(img => {
        img.onload = function() {
            img.classList.add("loaded");
            img.parentNode.querySelector(".spinner").style.display = "none";
        };
    });

    
function toggleMenu(x) {
    x.classList.toggle("change");
    document.querySelector("nav").classList.toggle("active");
}

function startSlideshow(className) {
    let index = 0;
    const slides = document.querySelectorAll("." + className);

    if (slides.length === 0) return;

    slides.forEach((slide, i) => {
        slide.style.opacity = "0";
        slide.style.transition = "opacity 1s ease-in-out"; // Smooth transition
        slide.style.position = "absolute";
        slide.style.width = "100%";
    });

    function showSlides() {
        slides.forEach((slide) => slide.style.opacity = "0");
        slides[index].style.opacity = "1";

        index = (index + 1) % slides.length;
    }

    showSlides();
    setInterval(showSlides, 2000); // Change image every 3 seconds
}

// Start slideshows for each room after the page loads
window.onload = function () {
    startSlideshow("koteshwara-slide");
    startSlideshow("maravanthe-slide");
    startSlideshow("uppinakudru-slide");
};





function toggleMenu(x) {
    x.classList.toggle("change");
    document.querySelector("nav").classList.toggle("active");
}

function startSlideshow(className) {
    let index = 0;
    const slides = document.querySelectorAll("." + className);

    if (slides.length === 0) return; // Prevent errors if no images

    function showSlides() {
        slides.forEach((slide, i) => {
            slide.classList.remove("active");
            if (i === index) {
                slide.classList.add("active");
            }
        });
        index = (index + 1) % slides.length;
    }
    
    showSlides();
    setInterval(showSlides, 3000); // Change image every 3 seconds
}

// Start slideshows for each room after the page loads
window.onload = function () {
    startSlideshow("koteshwara-slide");
    startSlideshow("maravanthe-slide");
    startSlideshow("uppinakudru-slide");
};






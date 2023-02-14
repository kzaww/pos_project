// detail page
const carousal = document.querySelector('.carousal');
const arrows = document.querySelectorAll('.next_prev');
const image = carousal.querySelectorAll('img')[0];
let isdragstart = false,
    isdragging = false,
    firstPagex, firstScrollLeft, positionDiff;
let imageWidth = image.clientWidth + 10;


const showHide = () => {
    let scrollwidth = carousal.scrollWidth - carousal.clientWidth;
    arrows[0].style.display = carousal.scrollLeft == 0 ? 'none' : 'block';
    arrows[1].style.display = carousal.scrollLeft == scrollwidth - 0.5 ? 'none' : 'block';
    if (window.matchMedia("(max-width:400px)").matches) return arrows[1].style.display = carousal.scrollLeft == scrollwidth ? 'none' : 'block';
}

const autoslide = () => {
    let scrollwidth = carousal.scrollWidth - carousal.clientWidth;
    // if (window.matchMedia("(max-width:400px)").matches) return;
    if (carousal.scrollLeft == scrollwidth - 0.5) return;
    if (carousal.scrollLeft == 0) return;
    positionDiff = Math.abs(positionDiff);
    let imageWidth = image.clientWidth + 10;
    let valDiff = imageWidth - positionDiff;

    if (carousal.scrollLeft > firstScrollLeft) {
        return carousal.scrollLeft += positionDiff > imageWidth / 3 ? valDiff : -positionDiff;
    }
    carousal.scrollLeft -= positionDiff > imageWidth / 3 ? valDiff : -positionDiff;

}

arrows.forEach(icon => {
    icon.addEventListener("click", () => {
        carousal.scrollLeft += icon.id == 'prev_btn' ? -imageWidth : imageWidth;
        // if (window.matchMedia("(max-width:400px)").matches) return console.log(carousal.scrollLeft);
        setTimeout(() => showHide(), 60);
        // console.log(carousal.scrollWidth - carousal.clientWidth);
    })

})


const dragstart = (e) => {
    isdragstart = true;
    firstPagex = e.pageX || e.touches[0].pageX; //get touch page x;
    firstScrollLeft = carousal.scrollLeft;
}

const dragging = (e) => {
    if (!isdragstart) return;
    e.preventDefault();
    positionDiff = (e.pageX || e.touches[0].pageX) - firstPagex;
    isdragging = true;
    carousal.scrollLeft = firstScrollLeft - positionDiff;
    carousal.classList.add('drag');
    setTimeout(() => showHide(), 60);
}

const dragstop = (e) => {
    isdragstart = false;
    carousal.classList.remove('drag');

    if (!isdragging) return;
    isdragging = false;
    autoslide();
}

carousal.addEventListener('scroll', (e) => {
    e.preventDefault();
    setTimeout(() => showHide(), 60);
})

carousal.addEventListener("mousedown", dragstart);
carousal.addEventListener("touchstart", dragstart);
carousal.addEventListener("mousemove", dragging);
carousal.addEventListener("touchmove", dragging);
carousal.addEventListener("mouseup", dragstop);
carousal.addEventListener("touchend", dragstop);
carousal.addEventListener("mouseleave", dragstop);

$(document).ready(function() {
    $('.btn_gp button').on('click', function() {
        var button = $(this);
        var oldValue = $('.pl_mi').val();
        if (button.hasClass('btn_plus')) {
            var newVal = parseFloat(oldValue) + 1;
        } else {
            if (oldValue > 0) {
                var newVal = parseFloat(oldValue) - 1;
            } else {
                newVal = 0;
            }
        }
        button.parent().find('input').val(newVal);
    });

    $(".item_box").click(function() {
        $(this).toggleClass('zoom');
    })
})
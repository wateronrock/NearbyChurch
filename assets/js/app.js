// 슬릭 커라우젤은 jquery기반의 라이브러리이기 때문에 jquery 라이브러리 cdn을 링크해 두어야 한다.
const slickSlide=jQuery('#slick-slide');

if(slickSlide){
    slickSlide.slick({
        dots: true,//아래 쪽에 점으로 표시할 것이냐
        arrows: false,//좌우 방향을 나타내는 화살표를 표시할 것이냐
        slidesToShow: 3, //일반 pc 화면에서는 3개를 보여준다
        slideToScroll: 1, //마우스나 손가락으로 밀어낼 때 몇 개의 슬라이드를 움직일 것이냐
        autoplay: true,
        autoplaySpeed:3000, //미리세컨드 단위이다. 3000이면 3초이다.
        responsive:[ //반응형 속성이다.
            {
                breakpoint:768,//px과 같은 단위는 적지 않는다, 768은 md 사이즈이다 sm~md까지는 두개가 보인다.
                settings:{
                    slidesToShow:2
                }
            },
            {
                breakpoint: 576, //sm 사이즈이다, 즉 가장 작은 사이즈에서 sm 사이즈까지는 슬라이드가 하나만 보인다.
                settings:{
                    slidesToShow:1
                }
            }
        ]
    });
}


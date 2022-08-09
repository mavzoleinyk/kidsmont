class Utils {
    slideUp(target, duration = 500) {
        target.style.transitionProperty = 'height, margin, padding';
        target.style.transitionDuration = duration + 'ms';
        target.style.height = target.offsetHeight + 'px';
        target.offsetHeight;
        target.style.overflow = 'hidden';
        target.style.height = 0;
        target.style.paddingTop = 0;
        target.style.paddingBottom = 0;
        target.style.marginTop = 0;
        target.style.marginBottom = 0;
        window.setTimeout(() => {
            target.style.display = 'none';
            target.style.removeProperty('height');
            target.style.removeProperty('padding-top');
            target.style.removeProperty('padding-bottom');
            target.style.removeProperty('margin-top');
            target.style.removeProperty('margin-bottom');
            target.style.removeProperty('overflow');
            target.style.removeProperty('transition-duration');
            target.style.removeProperty('transition-property');
            target.classList.remove('_slide');
        }, duration);
    }
    slideDown(target, duration = 500) {
        target.style.removeProperty('display');
        let display = window.getComputedStyle(target).display;
        if (display === 'none')
            display = 'block';

        target.style.display = display;
        let height = target.offsetHeight;
        target.style.overflow = 'hidden';
        target.style.height = 0;
        target.style.paddingTop = 0;
        target.style.paddingBottom = 0;
        target.style.marginTop = 0;
        target.style.marginBottom = 0;
        target.offsetHeight;
        target.style.transitionProperty = "height, margin, padding";
        target.style.transitionDuration = duration + 'ms';
        target.style.height = height + 'px';
        target.style.removeProperty('padding-top');
        target.style.removeProperty('padding-bottom');
        target.style.removeProperty('margin-top');
        target.style.removeProperty('margin-bottom');
        window.setTimeout(() => {
            target.style.removeProperty('height');
            target.style.removeProperty('overflow');
            target.style.removeProperty('transition-duration');
            target.style.removeProperty('transition-property');
            target.classList.remove('_slide');
        }, duration);
    }
    slideToggle(target, duration = 500) {
        if (!target.classList.contains('_slide')) {
            target.classList.add('_slide');
            if (window.getComputedStyle(target).display === 'none') {
                return this.slideDown(target, duration);
            } else {
                return this.slideUp(target, duration);
            }
        }
    }

    Android() {
        return navigator.userAgent.match(/Android/i);
    }
    BlackBerry() {
        return navigator.userAgent.match(/BlackBerry/i);
    }
    iOS() {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
    }
    Opera() {
        return navigator.userAgent.match(/Opera Mini/i);
    }
    Windows() {
        return navigator.userAgent.match(/IEMobile/i);
    }
    isMobile() {
        return (this.Android() || this.BlackBerry() || this.iOS() || this.Opera() || this.Windows());
    }

    scrollTrigger(el, value, callback) {
        let triggerPoint = document.documentElement.clientHeight / 100 * (100 - value);
        const trigger = () => {
            if (el.getBoundingClientRect().top <= triggerPoint && !el.classList.contains('is-show')) {
                if (typeof callback === 'function') {
                    callback();
                    el.classList.add('is-show')
                }
            }
        }

        trigger();

        window.addEventListener('scroll', trigger);
    }

    numberCounterAnim() {
        let counterItems = document.querySelectorAll('[data-number-counter-anim]');
        if (counterItems) {

            counterItems.forEach(item => {
                let animation = anime({
                    targets: item,
                    textContent: [0, item.innerText],
                    round: 1,
                    easing: 'linear',
                    autoplay: false,
                    duration: 1000
                });

                window.addEventListener('load', () => {
                    this.scrollTrigger(item, 15, () => { animation.play() })
                })
            })
        }
    }

    initTruncateString() {
        function truncateString(el, stringLength = 0) {
            let str = el.innerText;
            if (str.length <= stringLength) return;
            el.innerText = [...str].slice(0, stringLength).join('') + '...';
        }

        let truncateItems = document.querySelectorAll('[data-truncate-string]');
        if (truncateItems.length) {
            truncateItems.forEach(truncateItem => {
                truncateString(truncateItem, truncateItem.dataset.truncateString);
            })
        }
    }
}

// HTML data-da="where(uniq class name),when(breakpoint),position(digi)"
// e.x. data-da=".content__column-garden,992,2"
// https://github.com/FreelancerLifeStyle/dynamic_adapt

class DynamicAdapt {
    constructor(type) {
        this.type = type;
    }

    init() {
        this.оbjects = [];
        this.daClassname = '_dynamic_adapt_';
        this.nodes = [...document.querySelectorAll('[data-da]')];

        this.nodes.forEach((node) => {
            const data = node.dataset.da.trim();
            const dataArray = data.split(',');
            const оbject = {};
            оbject.element = node;
            оbject.parent = node.parentNode;
            оbject.destination = document.querySelector(`${dataArray[0].trim()}`);
            оbject.breakpoint = dataArray[1] ? dataArray[1].trim() : '767';
            оbject.place = dataArray[2] ? dataArray[2].trim() : 'last';
            оbject.index = this.indexInParent(оbject.parent, оbject.element);
            this.оbjects.push(оbject);
        });

        this.arraySort(this.оbjects);

        this.mediaQueries = this.оbjects
            .map(({
                breakpoint
            }) => `(${this.type}-width: ${breakpoint}px),${breakpoint}`)
            .filter((item, index, self) => self.indexOf(item) === index);

        this.mediaQueries.forEach((media) => {
            const mediaSplit = media.split(',');
            const matchMedia = window.matchMedia(mediaSplit[0]);
            const mediaBreakpoint = mediaSplit[1];

            const оbjectsFilter = this.оbjects.filter(
                ({
                    breakpoint
                }) => breakpoint === mediaBreakpoint
            );
            matchMedia.addEventListener('change', () => {
                this.mediaHandler(matchMedia, оbjectsFilter);
            });
            this.mediaHandler(matchMedia, оbjectsFilter);
        });
    }

    mediaHandler(matchMedia, оbjects) {
        if (matchMedia.matches) {
            оbjects.forEach((оbject) => {
                оbject.index = this.indexInParent(оbject.parent, оbject.element);
                this.moveTo(оbject.place, оbject.element, оbject.destination);
            });
        } else {
            оbjects.forEach(
                ({ parent, element, index }) => {
                    if (element.classList.contains(this.daClassname)) {
                        this.moveBack(parent, element, index);
                    }
                }
            );
        }
    }

    moveTo(place, element, destination) {
        if (destination) {
            element.classList.add(this.daClassname);
            if (place === 'last' || place >= destination.children.length) {
                destination.append(element);
                return;
            }
            if (place === 'first') {
                destination.prepend(element);
                return;
            }
            destination.children[place].before(element);
        }
    }

    moveBack(parent, element, index) {
        element.classList.remove(this.daClassname);
        if (parent.children[index] !== undefined) {
            parent.children[index].before(element);
        } else {
            parent.append(element);
        }
    }

    indexInParent(parent, element) {
        return [...parent.children].indexOf(element);
    }

    arraySort(arr) {
        if (this.type === 'min') {
            arr.sort((a, b) => {
                if (a.breakpoint === b.breakpoint) {
                    if (a.place === b.place) {
                        return 0;
                    }
                    if (a.place === 'first' || b.place === 'last') {
                        return -1;
                    }
                    if (a.place === 'last' || b.place === 'first') {
                        return 1;
                    }
                    return a.place - b.place;
                }
                return a.breakpoint - b.breakpoint;
            });
        } else {
            arr.sort((a, b) => {
                if (a.breakpoint === b.breakpoint) {
                    if (a.place === b.place) {
                        return 0;
                    }
                    if (a.place === 'first' || b.place === 'last') {
                        return 1;
                    }
                    if (a.place === 'last' || b.place === 'first') {
                        return -1;
                    }
                    return b.place - a.place;
                }
                return b.breakpoint - a.breakpoint;
            });
            return;
        }
    }
}


class App {
    constructor() {
        this.utils = new Utils();
        this.dynamicAdapt = new DynamicAdapt('max');
    }

    init() {
        if (this.utils.isMobile()) {
            document.body.classList.add('mobile');
        }

        if (this.utils.iOS()) {
            document.body.classList.add('mobile-ios');
        }

        document.body.classList.add('page-is-load');

        this.utils.numberCounterAnim();
        this.utils.initTruncateString();
        this.dynamicAdapt.init();
        this.headerHandler();
        this.popupHandler();
        this.initSmoothScroll();
        this.inputMaskInit();
        this.tabsInit();
        this.selectInit();
        this.spollerInit();
        this.componentsScriptsBeforeLoadPage();
        this.resetFormHandler();
        this.initDatepicker();
        this.initTooltip();
        this.initConstructorScripts();
        this.scrollTriggerAnimation();
        this.initScrollSticky();
        this.setFontSize();

        window.addEventListener('load', () => {
            
            this.componentsScriptsAfterLoadPage();
            this.setPaddingTopHeaderSize();
            this.slidersInit();
            this.setFullHeight();
        });

    }

    headerHandler() {
        let header = document.querySelector('[data-header]');
        let closeBtn = document.querySelector('[data-side-panel="menu-mobile"] [data-side-panel-close]')
        let mobileMenu = document.querySelector('[data-side-panel="menu-mobile"]');
        let deskMenuItemHasSubMenu = document.querySelector('[data-menu-item-has-sab-menu]');
        let mainSearch = document.querySelector('[data-main-search]');
        let btnShowMainSearchButtons = document.querySelectorAll('[data-action="show-main-search"]');
        let btnHideMainSearch = document.querySelector('[data-action="hide-main-search"]');

        if (header && mobileMenu) {

            let slider = document.querySelector('[data-mobile-menu-slider]');
            let triggerItem = document.querySelector('[data-action="show-next-list"]');
            let btnBack = document.querySelector('[data-action="hide-next-list"]');
            let sidePanelHead = mobileMenu.querySelector('.side-panel__head');
            let menuItems = header.querySelectorAll('.menu__list-item');
            let swiperSlider;

            const toggleShowBtnBack = (state) => {
                if (state === 'hide') {
                    btnBack.classList.remove('show');
                    sidePanelHead.classList.remove('side-panel__head--hide');
                } else if (state == 'show') {
                    btnBack.classList.add('show');
                    sidePanelHead.classList.add('side-panel__head--hide');
                }
            }

            if (slider) {
                swiperSlider = new Swiper(slider, {
                    observer: true,
                    observeParents: true,
                    slidesPerView: 1,
                    spaceBetween: 0,
                    speed: 300,
                    allowTouchMove: false,
                    autoHeight: true,

                    on: {
                        slideChange: () => {
                            swiperSlider.allowTouchMove = false;
                            toggleShowBtnBack('hide');
                        }
                    }
                });
            }

            if (triggerItem) {
                triggerItem.addEventListener('click', (e) => {
                    e.preventDefault();
                    swiperSlider.slideNext();
                    swiperSlider.allowTouchMove = true;
                    toggleShowBtnBack('show');
                })
            }

            menuItems.forEach(menuItem => {
                let links = menuItem.querySelectorAll('.sub-menu__link');
                let img = menuItem.querySelector('.menu__img img');

                if (img && links.length) {
                    links.forEach(link => {
                        link.addEventListener('mouseenter', () => {
                            img.src = link.dataset.imgUrl;
                        })
                    })
                }
            })

            closeBtn.addEventListener('click', () => {
                swiperSlider.slideTo(0);
                toggleShowBtnBack('hide');
            })

            btnBack.addEventListener('click', () => {
                swiperSlider.slideTo(0);
                toggleShowBtnBack('hide');
            })

            window.addEventListener('scroll', () => {
                header.classList.toggle('header--is-scroll', window.pageYOffset > 50);
            })

            window.addEventListener('load', () => {
                header.classList.add('show')
            });

        }

        if (mainSearch) {
            if (btnShowMainSearchButtons.length) {
                btnShowMainSearchButtons.forEach(btnShowMainSearch => {
                    btnShowMainSearch.addEventListener('click', (e) => {
                        e.preventDefault();
                        mainSearch.classList.add('main-search--show');
                        document.body.classList.add('cover');
                        document.body.classList.add('overflow-hidden');
                    })
                })
            }

            btnHideMainSearch.addEventListener('click', (e) => {
                e.preventDefault();
                mainSearch.classList.remove('main-search--show');
                document.body.classList.remove('cover');
                document.body.classList.remove('overflow-hidden');
            })
        }

        if (deskMenuItemHasSubMenu) {

            deskMenuItemHasSubMenu.addEventListener('mouseenter', () => {
                document.body.classList.add('cover');
            })
            deskMenuItemHasSubMenu.addEventListener('mouseleave', () => {
                document.body.classList.remove('cover');
            })
        }
        ;
    }

    popupHandler() {
        // ==== Popup form handler====

        const popupLinks = document.querySelectorAll('[data-popup="open-popup"]');
        const body = document.querySelector('body');
        const lockPadding = document.querySelectorAll('[data-popup="lock-padding"]');

        let unlock = true;

        const timeout = 800;

        if (popupLinks.length > 0) {
            for (let index = 0; index < popupLinks.length; index++) {
                const popupLink = popupLinks[index];
                popupLink.addEventListener('click', function (e) {
                    const popupName = popupLink.getAttribute('href').replace('#', '');
                    const curentPopup = document.getElementById(popupName);
                    popupOpen(curentPopup);
                    e.preventDefault();
                });
            }
        }


        const popupCloseIcon = document.querySelectorAll('[data-popup="close-popup"]');
        if (popupCloseIcon.length > 0) {
            for (let index = 0; index < popupCloseIcon.length; index++) {
                const el = popupCloseIcon[index];
                el.addEventListener('click', function (e) {
                    popupClose(el.closest('.popup'));
                    e.preventDefault();
                });
            }
        }

        function popupOpen(curentPopup) {
            if (curentPopup && unlock) {
                const popupActive = document.querySelector('.popup.popup--open');
                if (popupActive) {
                    popupClose(popupActive, false);
                } else {
                    bodyLock();
                }
                curentPopup.classList.add('popup--open');
                curentPopup.addEventListener('click', function (e) {
                    if (!e.target.closest('.popup__content')) {
                        popupClose(e.target.closest('.popup'));
                    }
                });

            }
        }

        function popupClose(popupActive, doUnlock = true) {
            if (unlock) {
                popupActive.classList.remove('popup--open');
                if (doUnlock) {
                    bodyUnlock();
                }
            }
        }

        function bodyLock() {
            const lockPaddingValue = window.innerWidth - document.querySelector('body').offsetWidth + 'px';
            let targetPadding = document.querySelectorAll('[data-popup="add-right-padding"]');
            if (targetPadding.length) {
                for (let index = 0; index < targetPadding.length; index++) {
                    const el = targetPadding[index];
                    el.style.paddingRight = lockPaddingValue;
                }
            }

            if (lockPadding.length > 0) {
                for (let index = 0; index < lockPadding.length; index++) {
                    const el = lockPadding[index];
                    el.style.paddingRight = lockPaddingValue;
                }
            }

            body.style.paddingRight = lockPaddingValue;
            body.classList.add('overflow-hidden');

            unlock = false;
            setTimeout(function () {
                unlock = true;
            }, timeout);
        }

        function bodyUnlock() {
            let targetPadding = document.querySelectorAll('[data-popup="add-right-padding"]');

            setTimeout(function () {
                if (targetPadding.length) {
                    for (let index = 0; index < targetPadding.length; index++) {
                        const el = targetPadding[index];
                        el.style.paddingRight = '0px';
                    }
                }

                for (let index = 0; index < lockPadding.length; index++) {
                    const el = lockPadding[index];
                    el.style.paddingRight = '0px';
                }

                body.style.paddingRight = '0px';
                body.classList.remove('overflow-hidden');
            }, timeout);

            unlock = false;
            setTimeout(function () {
                unlock = true;
            }, timeout);
        }

        document.addEventListener('keydown', function (e) {
            if (e.which === 27) {
                const popupActive = document.querySelector('.popup.popup--open');
                popupClose(popupActive);
            }
        });

        // === Polyfill ===
        (function () {
            if (!Element.prototype.closest) {
                Element.prototype.closest = function (css) {
                    var node = this;
                    while (node) {
                        if (node.matches(css)) return node;
                        else node == node.parentElement;
                    }
                    return null;
                };
            }
        })();

        (function () {
            if (!Element.prototype.matches) {
                Element.prototype.matches = Element.prototype.matchesSelector ||
                    Element.prototype.webkitMatchesSelector ||
                    Element.prototype.mozMatchesSelector ||
                    Element.prototype.mozMatchesSelector;
            }
        })();
        // === AND Polyfill ===

        // добавление API попапа в глобалную видимость
        window.popup = {
            open(id) {
                if (!id) return;

                let popup = document.querySelector(id);

                if (!popup) return;

                popupOpen(popup);
            },
            close(id) {
                if (!id) return;

                let popup = document.querySelector(id);

                if (!popup) return;

                popupClose(popup);
            }
        }
            ;
    }

    slidersInit() {
        {
            let productCarousel = document.querySelector('[data-slider="product-carousel"]');
            if (productCarousel) {
                let swiperProductCarousel = new Swiper(productCarousel.querySelector('.swiper'), {
                    speed: 1000,
                    loop: true,
                    navigation: {
                        nextEl: productCarousel.querySelector('[data-action="btn-next"]'),
                        prevEl: productCarousel.querySelector('[data-action="btn-prev"]'),
                    },
                    breakpoints: {
                        320: {
                            slidesPerView: 'auto',
                            spaceBetween: 20,
                            centeredSlides: false,
                        },
                        768: {
                            slidesPerView: 'auto',
                            spaceBetween: 50,
                            centeredSlides: true,
                        },
                        992: {
                            slidesPerView: 'auto',
                            spaceBetween: 102,
                            centeredSlides: true,
                        }
                    },
                });

            }
        };
        {
            let seeMoreBanAll = document.querySelectorAll('[data-slider="see-more-ban"]');
            if (seeMoreBanAll.length) {
                seeMoreBanAll.forEach(seeMoreBan => {
                    let swiperSeeMoreBan = new Swiper(seeMoreBan, {
                        autoplay: {
                            delay: 1,
                            disableOnInteraction: false,
                        },
                        slidesPerView: 'auto',
                        spaceBetween: 0,
                        speed: 7000,
                        loop: true,
                        freeMode: true
                    });
                })
            }
        };
        {
            let reviewsSlider = document.querySelector('[data-slider="reviews"]');
            if (reviewsSlider) {

                let swiperReviewsSlider = new Swiper(reviewsSlider.querySelector('.swiper'), {
                    speed: 1000,
                    navigation: {
                        nextEl: reviewsSlider.querySelector('[data-action="btn-next"]'),
                        prevEl: reviewsSlider.querySelector('[data-action="btn-prev"]'),
                    },
                    breakpoints: {
                        320: {
                            slidesPerView: 1,
                            spaceBetween: 20,
                            autoHeight: true,
                        },
                        768: {
                            slidesPerView: 'auto',
                            spaceBetween: 60,
                            autoHeight: false,
                        },
                    }
                });
            }
        };
        {
            let carousels = document.querySelectorAll('[data-carousel]');
            if (carousels.length) {
                carousels.forEach(carousel => {
                    let options = {
                        speed: 800,
                        navigation: {
                            nextEl: carousel.querySelector('[data-action="btn-next"]'),
                            prevEl: carousel.querySelector('[data-action="btn-prev"]'),
                        },
                        breakpoints: {
                            320: {
                                slidesPerView: 2,
                                spaceBetween: 15,
                                autoHeight: true,
                            },
                            768: {
                                slidesPerView: 3,
                                spaceBetween: 20,
                            },
                            992: {
                                slidesPerView: 4,
                                spaceBetween: 25,
                            },
                        },
                    }
                    if (carousel.dataset.carousel === 'fixed-width') {
                        options = {
                            ...options,
                            breakpoints: {
                                320: {
                                    slidesPerView: 2,
                                    spaceBetween: 15,
                                    autoHeight: true,
                                },
                                768: {
                                    slidesPerView: 3,
                                    spaceBetween: 20,
                                },
                                992: {
                                    slidesPerView: 'auto',
                                    spaceBetween: 25,
                                },
                            },
                        }
                    }

                    if (carousel.dataset.carousel === 'posts') {
                        options = {
                            ...options,
                            breakpoints: {
                                320: {
                                    slidesPerView: 'auto',
                                    spaceBetween: 20,
                                    autoHeight: true,
                                },
                                768: {
                                    slidesPerView: 3,
                                    spaceBetween: 20,
                                },
                                992: {
                                    slidesPerView: 4,
                                    spaceBetween: 25,
                                },
                            },
                        }
                    }
                    let carouselSwiper = new Swiper(carousel.querySelector('.swiper'), options);
                })
            }
        };
        {
            let galleryProductDetail = document.querySelector('[data-gallery-product-detail]');
            if (galleryProductDetail) {
                const slider = galleryProductDetail;
                if (slider) {
                    let mySwiper;

                    function mobileSlider() {
                        if (document.documentElement.clientWidth <= 991.98 && slider.dataset.mobile == 'false') {
                            mySwiper = new Swiper(slider, {
                                slidesPerView: 1,
                                speed: 800,
                                spaceBetween: 20,
                                pagination: {
                                    el: slider.querySelector('.swiper-pagination'),
                                    clickable: true,
                                },
                                on: {
                                    activeIndexChange: (e) => {
                                        if (e.activeIndex === 0) {
                                            galleryProductDetail.classList.remove('hide-cover-elements');
                                        } else {
                                            galleryProductDetail.classList.add('hide-cover-elements');
                                        }
                                    }
                                }
                            });

                            slider.dataset.mobile = 'true';

                            //mySwiper.slideNext(0);
                        }

                        if (document.documentElement.clientWidth > 992) {
                            slider.dataset.mobile = 'false';

                            if (slider.classList.contains('swiper-initialized')) {
                                mySwiper.destroy();
                            }
                        }
                    }

                    mobileSlider();

                    window.addEventListener('resize', () => {
                        mobileSlider();
                    })
                }
            }
        };
        {
            let articleSliders = document.querySelectorAll('[data-article-slider]');
            if (articleSliders.length) {
                articleSliders.forEach(articleSlider => {
                    let sliderData = new Swiper(articleSlider.querySelector('.swiper'), {
                        speed: 800,
                        navigation: {
                            nextEl: articleSlider.querySelector('[data-action="btn-next"]'),
                            prevEl: articleSlider.querySelector('[data-action="btn-prev"]'),
                        },
                        breakpoints: {
                            320: {
                                slidesPerView: 'auto',
                                spaceBetween: 20,
                            },
                            768: {
                                slidesPerView: 3,
                                spaceBetween: 25,
                            }
                        }
                    });
                })
            }
        };
        {
            let reviewsListCardSliders = document.querySelectorAll('[data-reviews-list-card-slider]');
            if (reviewsListCardSliders.length) {
                reviewsListCardSliders.forEach(reviewsListCardSlider => {
                    let options = {
                        speed: 800,
                        navigation: {
                            nextEl: reviewsListCardSlider.querySelector('.reviews-list-card__btn--next'),
                        },
                        breakpoints: {
                            320: {
                                slidesPerView: 'auto',
                                spaceBetween: 20,
                            },
                            768: {
                                slidesPerView: 3,
                                spaceBetween: 25,
                            },
                            992: {
                                slidesPerView: 2,
                                spaceBetween: 25,
                            }
                        }
                    }
                    if (reviewsListCardSlider.querySelector('.swiper-wrapper').children.length > 2 || document.documentElement.clientWidth < 768) {
                        options = {
                            ...options,
                            loop: true
                        }
                    }
                    let sliderData = new Swiper(reviewsListCardSlider, options);

                })
            }
        };
        {
            let galleryCarousel = document.querySelector('[data-gallery-carousel]');
            if (galleryCarousel) {
                let sliderData = new Swiper(galleryCarousel.querySelector('.swiper'), {
                    speed: 800,
                    navigation: {
                        nextEl: galleryCarousel.querySelector('[data-action="btn-next"]'),
                        prevEl: galleryCarousel.querySelector('[data-action="btn-prev"]'),
                    },
                    breakpoints: {
                        320: {
                            slidesPerView: 'auto',
                            spaceBetween: 20,
                        },
                        768: {
                            slidesPerView: 2,
                            spaceBetween: 25,
                        }
                    }
                });
            }
        };
        {
            let tabsNavAll = document.querySelectorAll('[data-tabs-nav]');
            if (tabsNavAll.length) {
                tabsNavAll.forEach(tabsNav => {
                    const slider = tabsNav;
                    if (slider) {
                        let mySwiper;

                        function mobileSlider() {
                            if (document.documentElement.clientWidth <= 767 && slider.dataset.mobile == 'false') {
                                mySwiper = new Swiper(slider, {
                                    slidesPerView: 'auto',
                                    slideToClickedSlide: true,
                                    speed: 800,
                                    freeMode: true,
                                    spaceBetween: 25,
                                });

                                slider.dataset.mobile = 'true';

                                //mySwiper.slideNext(0);
                            }

                            if (document.documentElement.clientWidth > 767) {
                                slider.dataset.mobile = 'false';

                                if (slider.classList.contains('swiper-initialized')) {
                                    mySwiper.destroy();
                                }
                            }
                        }

                        mobileSlider();

                        window.addEventListener('resize', () => {
                            mobileSlider();
                        })
                    }
                })
            }
        };
        {
            let blogPreview = document.querySelector('[data-slider="blog-preview"]');
            if (blogPreview) {
                const slider = blogPreview.querySelector('.swiper');
                if (slider) {
                    let mySwiper;

                    function mobileSlider() {
                        if (document.documentElement.clientWidth <= 767 && slider.dataset.mobile == 'false') {
                            mySwiper = new Swiper(slider, {
                                slidesPerView: 'auto',
                                speed: 800,
                                spaceBetween: 20,
                                navigation: {
                                    nextEl: blogPreview.querySelector('[data-action="btn-next"]'),
                                    prevEl: blogPreview.querySelector('[data-action="btn-prev"]'),
                                },
                            });

                            slider.dataset.mobile = 'true';

                            //mySwiper.slideNext(0);
                        }

                        if (document.documentElement.clientWidth > 767) {
                            slider.dataset.mobile = 'false';

                            if (slider.classList.contains('swiper-initialized')) {
                                mySwiper.destroy();
                            }
                        }
                    }

                    mobileSlider();

                    window.addEventListener('resize', () => {
                        mobileSlider();
                    })
                }

            }
        };
        {
            let benefitsList = document.querySelector('[data-slider="benefits-list"]');
            if (benefitsList) {
                const slider = benefitsList;
                if (slider) {
                    let mySwiper;

                    function mobileSlider() {
                        if (document.documentElement.clientWidth <= 767 && slider.dataset.mobile == 'false') {
                            mySwiper = new Swiper(slider, {
                                slidesPerView: 1,
                                speed: 800,
                                pagination: {
                                    el: slider.querySelector('.swiper-pagination'),
                                    clickable: true,
                                },
                            });

                            slider.dataset.mobile = 'true';

                            //mySwiper.slideNext(0);
                        }

                        if (document.documentElement.clientWidth > 767) {
                            slider.dataset.mobile = 'false';

                            if (slider.classList.contains('swiper-initialized')) {
                                mySwiper.destroy();
                            }
                        }
                    }

                    mobileSlider();

                    window.addEventListener('resize', () => {
                        mobileSlider();
                    })
                }
            }
        };
    }

    tabsInit() {
        let tabsContainers = document.querySelectorAll('[data-tabs]');
        if (tabsContainers.length) {
            tabsContainers.forEach(tabsContainer => {
                let triggerItems = Array.from(tabsContainer.querySelectorAll('[data-tab-trigger]'));
                let contentItems = Array.from(tabsContainer.querySelectorAll('[data-tab-content]'));
                let select = tabsContainer.querySelector('[data-tab-select]');

                const getContentItem = (id) => {
                    if (!id.trim()) return;
                    return contentItems.filter(item => item.dataset.tabContent === id)[0];
                }

                if (tabsContainer.hasAttribute('data-tabs-sub')) {
					triggerItems = triggerItems.filter(i => i.closest('[data-tabs-sub]'))
					contentItems = contentItems.filter(i => i.closest('[data-tabs-sub]'))
				} else {
					triggerItems = triggerItems.filter(i => !i.closest('[data-tabs-sub]'))
					contentItems = contentItems.filter(i => !i.closest('[data-tabs-sub]'))
				}

                if (triggerItems.length && contentItems.length) {
                    // init
                    let activeItem = tabsContainer.querySelector('.tab-active[data-tab-trigger]');
                    if (activeItem) {
                        activeItem.classList.add('tab-active');
                        getContentItem(activeItem.dataset.tabTrigger).classList.add('tab-active');
                    } else {
                        triggerItems[0].classList.add('tab-active');
                        getContentItem(triggerItems[0].dataset.tabTrigger).classList.add('tab-active');
                    }

                    triggerItems.forEach(item => {
                        item.addEventListener('click', (e) => {
                            e.preventDefault();
                            item.classList.add('tab-active');
                            getContentItem(item.dataset.tabTrigger).classList.add('tab-active');

                            triggerItems.forEach(i => {
                                if (i === item) return;

                                i.classList.remove('tab-active');
                                getContentItem(i.dataset.tabTrigger).classList.remove('tab-active');
                            })
                        })
                    })
                }

                if (select) {
                    select.addEventListener('change', (e) => {
                        getContentItem(e.target.value).classList.add('tab-active');

                        contentItems.forEach(item => {
                            if (getContentItem(e.target.value) === item) return;

                            item.classList.remove('tab-active');
                        })
                    })
                }

                if (tabsContainer.dataset.tabs === 'has-outside-navigation') {
                    let outsideNavigation = document.querySelector('[data-tabs-outside-nav]');
                    if (outsideNavigation) {
                        let triggerItems = outsideNavigation.querySelectorAll('[data-tab-trigger]');

                        // init
                        let activeItem = tabsContainer.querySelector('.tab-active[data-tab-trigger]');
                        if (activeItem) {
                            activeItem.classList.add('tab-active');
                            getContentItem(activeItem.dataset.tabTrigger).classList.add('tab-active');
                        } else {
                            triggerItems[0].classList.add('tab-active');
                            getContentItem(triggerItems[0].dataset.tabTrigger).classList.add('tab-active');
                        }

                        triggerItems.forEach(item => {
                            item.addEventListener('click', (e) => {
                                e.preventDefault();
                                item.classList.add('tab-active');
                                getContentItem(item.dataset.tabTrigger).classList.add('tab-active');

                                triggerItems.forEach(i => {
                                    if (i === item) return;

                                    i.classList.remove('tab-active');
                                    getContentItem(i.dataset.tabTrigger).classList.remove('tab-active');
                                })

                                window.sidePanel.close('faq-items');
                            })
                        })
                    }
                }


                // open found resutl
                let serchResult = document.querySelector('.search-result');
                if (serchResult) {
                    let faqSearch = document.querySelector('.faq__search');
                    let outsideNavItems = document.querySelectorAll('[data-side-panel="faq-items"] [data-tabs-outside-nav] [data-tab-trigger]')

                    if (document.documentElement.clientWidth < 768) {
                        if (faqSearch) {
                            faqSearch.append(serchResult);
                        }
                    }

                    serchResult.addEventListener('click', (e) => {

                        if (e.target.classList.contains('search-link')) {
                            let link = e.target;
                            let elId = link.getAttribute('href').match(/#\w+$/gi).join('');
                            let [tab] = triggerItems.filter(i => i.dataset.tabTrigger === link.dataset.term);
                            let questionEl = document.querySelector(`${elId}`);

                            if (tab) {
                                tab.classList.add('tab-active');
                                getContentItem(tab.dataset.tabTrigger).classList.add('tab-active');

                                triggerItems.forEach(i => {
                                    if (i === tab) return;

                                    i.classList.remove('tab-active');
                                    getContentItem(i.dataset.tabTrigger).classList.remove('tab-active');
                                })

                            }

                            if (questionEl) {
                                let spollerTrigger = questionEl.querySelector('[data-spoller-trigger]');
                                if (spollerTrigger) {
                                    let collapseContent = spollerTrigger.nextElementSibling;
                                    let spollerTriggers = spollerTrigger.closest('[data-spoller]').querySelectorAll('[data-spoller-trigger]');

                                    if (collapseContent) {
                                        spollerTrigger.classList.add('active');
                                        spollerTrigger.parentElement.classList.add('active');
                                        this.utils.slideDown(collapseContent);

                                        if (spollerTriggers.length) {
                                            spollerTriggers.forEach(i => {
                                                if (i === spollerTrigger) return;

                                                i.classList.remove('active');
                                                i.parentElement.classList.remove('active');
                                                this.utils.slideUp(i.nextElementSibling);
                                            })
                                        }
                                    }
                                }

                                if (document.documentElement.clientHeight - questionEl.clientHeight < questionEl.getBoundingClientRect().top) {
                                    setTimeout(() => {
                                        window.scrollTo({
                                            top: questionEl.getBoundingClientRect().top - 100,
                                            behavior: 'smooth',
                                        })
                                    }, 200)
                                }

                            }

                            if (outsideNavItems.length) {
                                outsideNavItems.forEach(trigger => {
                                    if (trigger.dataset.tabTrigger === link.dataset.term) {
                                        trigger.classList.add('tab-active');
                                    } else {
                                        trigger.classList.remove('tab-active');
                                    }
                                })
                            }

                            if (document.documentElement.clientWidth < 768) {
                                if (faqSearch) {
                                    e.preventDefault();
                                    faqSearch.classList.remove('faq__search--show');
                                    document.body.classList.remove('cover');
                                    document.body.classList.remove('overflow-hidden');
                                }
                            }

                        }
                    })
                }

            })
        }
    }

    spollerInit() {
        let spollers = document.querySelectorAll('[data-spoller]');

        if (spollers.length) {
            spollers.forEach(spoller => {
                let isOneActiveItem = spoller.dataset.spoller.trim() === 'one' ? true : false;
                let mobModification = spoller.dataset.spoller.trim() === 'mob' ? true : false;

                let triggers;
                if (spoller.dataset.hasOwnProperty('subSpoller')) {
                    triggers = spoller.querySelectorAll('[data-spoller-trigger]');
                } else {
                    triggers = spoller.querySelectorAll('[data-spoller-trigger]:not([data-sub-spoller] [data-spoller-trigger])');
                }
                if (triggers.length) {
                    triggers.forEach(trigger => {
                        let parent = trigger.parentElement;
                        let content = trigger.nextElementSibling;

                        // init
                        if (trigger.classList.contains('active')) {
                            content.style.display = 'block';
                        }

                        trigger.addEventListener('click', (e) => {

                            if (mobModification && document.documentElement.clientWidth > 991.98) return;

                            e.preventDefault();
                            parent.classList.toggle('active');
                            trigger.classList.toggle('active');
                            content && this.utils.slideToggle(content);

                            if (isOneActiveItem || mobModification) {
                                triggers.forEach(i => {
                                    if (i === trigger) return;

                                    let parent = i.parentElement;
                                    let content = i.nextElementSibling;

                                    parent.classList.remove('active');
                                    i.classList.remove('active');
                                    content && this.utils.slideUp(content);
                                })
                            }

                        })
                    })
                }
            })
        }
    }

    inputMaskInit() {
        let items = document.querySelectorAll('[data-mask]');
        if (items.length) {
            items.forEach(item => {
                let maskValue = item.dataset.mask;
                let inputs = item.querySelectorAll('input');
                if (inputs.length) {
                    inputs.forEach(input => {
                        if (input) {
                            Inputmask(maskValue, {
                                //"placeholder": '',
                                clearIncomplete: true,
                                clearMaskOnLostFocus: true,
                                showMaskOnHover: false,
                            }).mask(input);
                        }
                    })
                }
            })
        }
    }

    setPaddingTopHeaderSize() {
        let wrapper = document.querySelector('[data-padding-top-header-size]');
        if (wrapper) {
            let header = document.querySelector('[data-header]');
            if (header) {
                const setPedding = () => wrapper.style.paddingTop = header.clientHeight + 'px';
                setPedding();
                let id = setInterval(setPedding, 200);
                setTimeout(() => {
                    clearInterval(id);
                }, 2000)
                window.addEventListener('resize', setPedding);
            }

        }
    }

    videoHandlerInit() {

        function togglePlayPause(video, btn) {
            if (video.paused) {
                video.play();
                btn.classList.remove('video-block__controll--play');
                btn.classList.add('video-block__controll--pause');
                video.setAttribute('controls', true);

            } else {
                video.pause();
                btn.classList.add('video-block__controll--play');
                btn.classList.remove('video-block__controll--pause');
                btn.style.opacity = '1';
            }
        }

        let videoBlock = document.querySelectorAll('[data-video]');
        if (videoBlock.length) {
            videoBlock.forEach((item) => {
                let videoWrap = item.querySelector('.video-block__video-wrap');
                let video = item.querySelector('.video-block__video');
                let btn = item.querySelector('.video-block__controll');

                if (video) {
                    btn.addEventListener('click', (e) => {
                        e.preventDefault();
                        togglePlayPause(video, btn);
                    });

                    video.addEventListener('ended', () => {
                        video.pause();
                        btn.classList.add('video-block__controll--play');
                        btn.classList.remove('video-block__controll--pause');
                        btn.style.opacity = '1';
                        video.removeAttribute('controls');
                    });

                    video.addEventListener('play', () => {
                        btn.classList.remove('video-block__controll--play');
                        btn.classList.add('video-block__controll--pause');

                        if (this.utils.isMobile()) {
                            btn.style.opacity = '0';
                        }
                    });

                    video.addEventListener('pause', () => {
                        btn.classList.add('video-block__controll--play');
                        btn.classList.remove('video-block__controll--pause');
                    });

                    videoWrap.addEventListener('mouseenter', (e) => {
                        if (!video.paused) {
                            btn.style.opacity = '1';
                        }
                    });

                    videoWrap.addEventListener('mouseleave', (e) => {
                        if (!video.paused) {
                            btn.style.opacity = '0';
                        }
                    });
                }
            })
        }

        {
            let vimeoVideos = document.querySelectorAll('[data-vimeo-id]');
            if (vimeoVideos.length) {
                vimeoVideos.forEach(async video => {
                    let id = video.dataset.vimeoId;
                    let img = video.querySelector('img');

                    if (document.documentElement.clientWidth < 992) {
                        if (video.dataset.vimeoMobileId.trim()) {
                            id = video.dataset.vimeoMobileId;
                        }
                    }

                    if (!/[a-z]/gi.test(id)) {
                        video.insertAdjacentHTML('beforeend', `<iframe src="https://player.vimeo.com/video/${id}?muted=1&amp;autoplay=1&amp;controls=0&amp;loop=1&amp;background=1&amp"  frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen allow="autoplay;" ></iframe>`);
                        let iframe = video.querySelector('iframe')
                        iframe.onload = () => {
                            if (img) {
                                img.style.opacity = 0;
                            }
                        }

                        setCoverVideoIframe(iframe, video, { desk: { w: 16.56, h: 9.31 }, mob: { w: 5.55, h: 7 } });
                    } else {
                        video.insertAdjacentHTML('beforeend', `<iframe src="https://iframe.videodelivery.net/${id}?autoplay=true&muted=true&controls=false" frameBorder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowFullScreen ></iframe>`);
                        let iframe = video.querySelector('iframe');
                        iframe.onload = () => {
                            if (img) {
                                img.style.opacity = 0;
                            }
                        }
                        setCoverVideoIframe(iframe, video, { desk: { w: 16, h: 9 }, mob: { w: 555, h: 700 } });

                    }

                })
            }

            function setCoverVideoIframe(iframe, parent, size) {

                const setSize = (widthVideo = 16.56, heightVideo = 9.31) => {
                    let percentHeight = heightVideo / widthVideo * 100;
                    let percentWidth = widthVideo / heightVideo * 100;

                    if ((parent.clientHeight / parent.clientWidth * 100) < percentHeight) {
                        iframe.style.width = '100%';
                        iframe.style.height = (parent.clientWidth / 100 * percentHeight) + 'px';
                    } else {
                        iframe.style.width = (parent.clientHeight / 100 * percentWidth) + 'px';
                        iframe.style.height = '100%';
                    }
                }

                if (document.documentElement.clientWidth >= 768) {
                    setSize(size.desk.w, size.desk.h);
                } else {
                    setSize(size.mob.w, size.mob.h);
                }

                window.addEventListener('resize', () => {
                    if (document.documentElement.clientWidth >= 768) {
                        setSize(size.desk.w, size.desk.h);
                    } else {
                        setSize(size.mob.w, size.mob.h);
                    }
                });
            }


            let youtubeVideos = document.querySelectorAll('[data-youtube-id]');
            if (youtubeVideos.length) {
                youtubeVideos.forEach(video => {
                    let videoContainer = document.createElement('div');
                    video.append(videoContainer);
                    let videoId = video.dataset.youtubeId;
                    let img = video.querySelector('img');

                    if (document.documentElement.clientWidth < 992) {
                        if (video.dataset.youtubeMobileId.trim()) {
                            videoId = video.dataset.youtubeMobileId;
                        }
                    }
                    let player = new YT.Player(videoContainer, {
                        height: 'auto',
                        width: 'auto',
                        videoId: videoId,
                        playerVars: {
                            autoplay: 1,
                            loop: 1,
                            playlist: videoId,
                            controls: 0,
                            enablejsapi: 1,
                        },
                        events: {
                            onReady: (e) => {
                                e.target.mute();
                                e.target.playVideo();

                                if (img) {
                                    img.style.opacity = 0;
                                }
                            }
                        }
                    });
                })
            }


            function setMobileVideoForBanner() {
                let videos = document.querySelectorAll('[data-media-mobile]');
                if (videos.length) {
                    videos.forEach(video => {
                        let url = video.dataset.mediaMobile;
                        Array.from(video.children).forEach(item => {
                            item.setAttribute('src', url);
                        })

                        video.load();
                    })
                }
            }

            if (document.documentElement.clientWidth < 768) {
                setMobileVideoForBanner()
            }

            let fancyboxYoutubeLinks = document.querySelectorAll('[data-fancybox-youtube]');
            if (fancyboxYoutubeLinks.length) {
                fancyboxYoutubeLinks.forEach(link => {
                    let id = link.getAttribute('href');
                    if (/https:\/\/www\.youtube\.com/i.test(id)) return;
                    link.setAttribute('href', `https://www.youtube.com/watch?v=${id}`)
                })
            }

            let fancyboxVimeoLinks = document.querySelectorAll('[data-fancybox-vimeo]');
            if (fancyboxVimeoLinks.length) {
                fancyboxVimeoLinks.forEach(link => {
                    let id = link.getAttribute('href');
                    if (/https:\/\/vimeo\.com\//i.test(id)) return;
                    link.setAttribute('href', `https://vimeo.com/${id}`)
                })
            }
        };
    }

    initSmoothScroll() {
		let anchors = document.querySelectorAll('a[href*="#"]:not([data-popup="open-popup"])');
		if (anchors.length) {
			let header = document.querySelector('.header');

			anchors.forEach(anchor => {
				if (!anchor.getAttribute('href').match(/#\w+$/gi)) return;

				let id = anchor.getAttribute('href').match(/#\w+$/gi).join('').replace('#', '');

				anchor.addEventListener('click', (e) => {
					let el = document.querySelector(`#${id}`);

					if (el) {
						e.preventDefault();
						let top = Math.abs(document.body.getBoundingClientRect().top) + el.getBoundingClientRect().top;

						if (header) {
							top = top - header.clientHeight;
						}

						window.scrollTo({
							top: top,
							behavior: 'smooth',
						})
					} else {
						e.preventDefault();
						window.scrollTo({
							top: 0,
							behavior: 'smooth',
						})
					}
				})

			})
		}
    }

    selectInit() {
        {
            function _slideUp(target, duration = 500) {
                target.style.transitionProperty = 'height, margin, padding';
                target.style.transitionDuration = duration + 'ms';
                target.style.height = target.offsetHeight + 'px';
                target.offsetHeight;
                target.style.overflow = 'hidden';
                target.style.height = 0;
                target.style.paddingTop = 0;
                target.style.paddingBottom = 0;
                target.style.marginTop = 0;
                target.style.marginBottom = 0;
                window.setTimeout(() => {
                    target.style.display = 'none';
                    target.style.removeProperty('height');
                    target.style.removeProperty('padding-top');
                    target.style.removeProperty('padding-bottom');
                    target.style.removeProperty('margin-top');
                    target.style.removeProperty('margin-bottom');
                    target.style.removeProperty('overflow');
                    target.style.removeProperty('transition-duration');
                    target.style.removeProperty('transition-property');
                    target.classList.remove('_slide');
                }, duration);
            }
            function _slideDown(target, duration = 500) {
                target.style.removeProperty('display');
                let display = window.getComputedStyle(target).display;
                if (display === 'none')
                    display = 'block';

                target.style.display = display;
                let height = target.offsetHeight;
                target.style.overflow = 'hidden';
                target.style.height = 0;
                target.style.paddingTop = 0;
                target.style.paddingBottom = 0;
                target.style.marginTop = 0;
                target.style.marginBottom = 0;
                target.offsetHeight;
                target.style.transitionProperty = "height, margin, padding";
                target.style.transitionDuration = duration + 'ms';
                target.style.height = height + 'px';
                target.style.removeProperty('padding-top');
                target.style.removeProperty('padding-bottom');
                target.style.removeProperty('margin-top');
                target.style.removeProperty('margin-bottom');
                window.setTimeout(() => {
                    target.style.removeProperty('height');
                    target.style.removeProperty('overflow');
                    target.style.removeProperty('transition-duration');
                    target.style.removeProperty('transition-property');
                    target.classList.remove('_slide');
                }, duration);
            }
            function _slideToggle(target, duration = 500) {
                if (!target.classList.contains('_slide')) {
                    target.classList.add('_slide');
                    if (window.getComputedStyle(target).display === 'none') {
                        return _slideDown(target, duration);
                    } else {
                        return _slideUp(target, duration);
                    }
                }
            }

            //Select
            let selects = document.querySelectorAll('select:not(.created)');
            if (selects.length > 0) {
                selects_init();
            }
            function selects_init() {
                for (let index = 0; index < selects.length; index++) {
                    const select = selects[index];
                    select_init(select);
                }
                //select_callback();
                document.addEventListener('click', function (e) {
                    selects_close(e);
                });
                document.addEventListener('keydown', function (e) {
                    if (e.which == 27) {
                        selects_close(e);
                    }
                });
            }
            function selects_close(e) {
                const selects = document.querySelectorAll('.select');
                if (!e.target.closest('.select')) {
                    for (let index = 0; index < selects.length; index++) {
                        const select = selects[index];
                        const select_body_options = select.querySelector('.select__options');
                        select.classList.remove('_active');
                        _slideUp(select_body_options, 100);
                    }
                }
            }
            function select_init(select) {
                const select_parent = select.parentElement;
                const select_modifikator = select.getAttribute('class');
                const select_selected_option = select.querySelector('option:checked');
                select.classList.add('created');
                select.setAttribute('data-default', select_selected_option.value);
                select.style.display = 'none';

                select_parent.insertAdjacentHTML('beforeend', `<div class="select select_${select_modifikator} ${select_selected_option.value.trim() ? "not-placeholder" : ""}"></div>`);

                let new_select = select.parentElement.querySelector('.select');
                new_select.appendChild(select);
                select_item(select);
            }
            function select_item(select) {
                const select_parent = select.parentElement;
                const select_items = select_parent.querySelector('.select__item');
                const select_options = select.querySelectorAll('option');
                const select_selected_option = select.querySelector('option:checked');
                const select_selected_text = select_selected_option.innerHTML;
                const select_type = select.getAttribute('data-type');
                const label = '<span class="select__label">Price:</span>';
                let select_selected_option_label = '';

                if (select_items) {
                    select_items.remove();
                }

                let select_type_content = '';
                if (select_type == 'input') {
                    select_type_content = '<div class="select__value icon-select-arrow"><input autocomplete="off" type="text" name="form[]" value="' + select_selected_text + '" data-error="Ошибка" data-value="' + select_selected_text + '" class="select__input"></div>';
                } else {
                    select_type_content = '<div class="select__value icon-select-arrow"><span>' + select_selected_text + '</span></div>';
                }

                if (!select_selected_option.value.trim()) {
                    select_selected_option_label = `<div class="select__label">${select_selected_text}</div>`;
                }

                select_parent.insertAdjacentHTML('beforeend',
                    select_selected_option_label +
                    '<div class="select__item">' +
                    `<div class="select__title">${(select.dataset.select === 'price') ? label : ''}` + select_type_content + '</div>' +
                    '<div class="select__options">' + select_get_options(select_options) + '</div>' +
                    '</div></div>');

                select_actions(select, select_parent);
            }
            function select_actions(original, select) {
                const select_item = select.querySelector('.select__item');
                const select_body_options = select.querySelector('.select__options');
                const select_options = select.querySelectorAll('.select__option');
                const select_type = original.getAttribute('data-type');
                const select_input = select.querySelector('.select__input');

                select_item.addEventListener('click', function () {
                    let selects = document.querySelectorAll('.select');
                    for (let index = 0; index < selects.length; index++) {
                        const select = selects[index];
                        const select_body_options = select.querySelector('.select__options');
                        if (select != select_item.closest('.select')) {
                            select.classList.remove('_active');
                            _slideUp(select_body_options, 100);
                        }
                    }
                    _slideToggle(select_body_options, 100);
                    select.classList.toggle('_active');
                });

                for (let index = 0; index < select_options.length; index++) {
                    const select_option = select_options[index];
                    const select_option_value = select_option.getAttribute('data-value');
                    const select_option_text = select_option.innerHTML;

                    if (select_type == 'input') {
                        select_input.addEventListener('keyup', select_search);
                    } else {
                        if (select_option.getAttribute('data-value') == original.value) {
                            select_option.style.display = 'none';
                        }
                    }
                    select_option.addEventListener('click', function () {
                        for (let index = 0; index < select_options.length; index++) {
                            const el = select_options[index];
                            el.style.display = 'block';
                        }
                        if (select_type == 'input') {
                            select_input.value = select_option_text;
                            original.value = select_option_value;
                        } else {
                            select.querySelector('.select__value').innerHTML = '<span>' + select_option_text + '</span>';
                            original.value = select_option_value;
                            select_option.style.display = 'none';
                            select.classList.add('_visited');

                            let event = new Event("change", { bubbles: true });
                            original.dispatchEvent(event);
                        }
                    });
                }
            }
            function select_get_options(select_options) {
                if (select_options) {
                    let select_options_content = '';
                    for (let index = 0; index < select_options.length; index++) {
                        const select_option = select_options[index];
                        const select_option_value = select_option.value;
                        if (select_option_value != '') {
                            const select_option_text = select_option.text;
                            select_options_content = select_options_content + '<div data-value="' + select_option_value + '" class="select__option">' + select_option_text + '</div>';
                        } else {

                        }
                    }
                    return select_options_content;
                }
            }
            function select_search(e) {
                let select_block = e.target.closest('.select ').querySelector('.select__options');
                let select_options = e.target.closest('.select ').querySelectorAll('.select__option');
                let select_search_text = e.target.value.toUpperCase();

                for (let i = 0; i < select_options.length; i++) {
                    let select_option = select_options[i];
                    let select_txt_value = select_option.textContent || select_option.innerText;
                    if (select_txt_value.toUpperCase().indexOf(select_search_text) > -1) {
                        select_option.style.display = "";
                    } else {
                        select_option.style.display = "none";
                    }
                }
            }
            function selects_update_all() {
                let selects = document.querySelectorAll('select');
                if (selects) {
                    for (let index = 0; index < selects.length; index++) {
                        const select = selects[index];
                        select_item(select);
                    }
                }
            }



        };
    }

    setFontSize() {
        let elements = document.querySelectorAll('[data-set-font-size]');
        if (elements.length) {
            elements.forEach(el => {
                const setFontSize = () => {
                    let value = 10 / 1400 * el.clientWidth;
                    el.style.fontSize = value + 'px';
                }

                setFontSize();

                window.addEventListener('resize', setFontSize);
            })
        }
    }

    resetFormHandler() {
        let resetButtons = document.querySelectorAll('[data-button-reset]');
        if (resetButtons.length) {
            resetButtons.forEach(resetButton => {
                let count = 0;
                let form = resetButton.closest('form');
                let checkboxInputs = form.querySelectorAll('input[type="checkbox"]');
                let numBox = resetButton.querySelector('span');
                let inputPriceStart = form.querySelector('.price-range__input--start');
                let inputPriceEnd = form.querySelector('.price-range__input--end');

                // init
                numBox.innerText = count;

                checkboxInputs.forEach(checkboxInput => {
                    checkboxInput.addEventListener('change', () => {
                        if (checkboxInput.checked) {
                            count++;
                        } else {
                            count--;
                        }

                        numBox.innerText = count;
                    })
                })

                form.addEventListener('reset', (e) => {
                    e.preventDefault();
                    count = 0;
                    numBox.innerText = count;

                    checkboxInputs.forEach(checkboxInput => {
                        checkboxInput.checked = false;
                    })

                    if (inputPriceStart) {
                        inputPriceStart.value = 0;
                        window.priceSlider.noUiSlider.set([0, null]);
                    }

                    if (inputPriceEnd) {
                        let value = inputPriceEnd.closest('.price-range').dataset.max;
                        inputPriceStart.value = value;
                        window.priceSlider.noUiSlider.set([null, value]);
                    }
                })
            })
        }
    }

    componentsScriptsBeforeLoadPage() {
        {
            let gPayBtn = document.querySelector('#wcpay-payment-request-button');
            if (gPayBtn) {


                let observer = new MutationObserver(mutationRecords => {
                    let inner = gPayBtn.querySelector('.__PrivateStripeElement');
                    let iframe = gPayBtn.querySelector('iframe');

                    if (inner) {
                        inner.removeAttribute('style');
                    }
                    if (iframe) {
                        iframe.removeAttribute('style');
                    }
                });

                observer.observe(gPayBtn, {
                    childList: true,
                    subtree: true,
                });
            }


        }


        {
            let textareaAll = document.querySelectorAll('[data-textarea]');
            if (textareaAll.length) {
                textareaAll.forEach(textarea => {
                    let placeholder = textarea.placeholder.trim();
                    // add wrapper
                    let wrapper = document.createElement('div');
                    wrapper.className = 'textarea-wrapper';
                    textarea.before(wrapper);
                    wrapper.append(textarea);

                    // add mask
                    let textMask = document.createElement('div');
                    textMask.className = 'textarea-text-mask';
                    wrapper.append(textMask);

                    // add size box
                    let sizeBox = document.createElement('div');
                    sizeBox.className = 'textarea-size-box';
                    wrapper.append(sizeBox);

                    if (textarea.placeholder.trim()) {
                        let label = document.createElement('div');
                        label.className = 'textarea-label';
                        label.innerHTML = textarea.placeholder.trim();
                        wrapper.append(label);
                    }

                    textarea.addEventListener('change', (e) => {

                    })

                    textarea.addEventListener('input', (e) => {
                        wrapper.classList.toggle('textarea-has-text', e.target.value.length > 0);
                        sizeBox.innerText = e.target.value;
                        textarea.style.height = sizeBox.clientHeight + 'px';
                        textMask.innerText = e.target.value;
                    })

                    textarea.addEventListener('focus', () => {
                        wrapper.classList.add('textarea-is-focus');
                        textarea.style.height = sizeBox.clientHeight + 'px';
                        textarea.placeholder = '';
                    })
                    textarea.addEventListener('blur', () => {
                        wrapper.classList.remove('textarea-is-focus');
                        textarea.removeAttribute('style');
                        textarea.placeholder = placeholder;
                    })
                })
            }
        }

        {
            let defaultInputs = document.querySelectorAll('input');
            if (defaultInputs.length) {
                defaultInputs.forEach(input => {
                    if (input.placeholder.trim()) {
                        let placeholder = input.placeholder.trim();

                        input.addEventListener('focus', () => {
                            input.placeholder = '';
                        })
                        input.addEventListener('blur', () => {
                            input.placeholder = placeholder;
                        })
                    }
                })
            }

            let inputs = document.querySelectorAll('.input:not(.not-label)');
            if (inputs.length) {
                inputs.forEach(input => {
                    if (input.placeholder.trim()) {
                        let inputWrap = document.createElement('div');
                        let label = document.createElement('div');
                        label.className = 'input-label';
                        label.innerText = input.placeholder;
                        inputWrap.className = 'input-wrap';
                        input.after(inputWrap);
                        inputWrap.append(input);
                        inputWrap.append(label);


                        input.addEventListener('focus', () => {
                            inputWrap.classList.add('input-is-focus');
                        })
                        input.addEventListener('blur', () => {
                            inputWrap.classList.remove('input-is-focus');
                        })

                        input.addEventListener('input', (e) => {
                            inputWrap.classList.toggle('input-has-text', e.target.value.length > 0);
                        })
                    }
                })
            }
        }

        {
            let passwordAll = document.querySelectorAll('[data-password]');
            if (passwordAll.length) {
                passwordAll.forEach(password => {
                    let input = password.querySelector('input');

                    if (input) {
                        // init
                        input.setAttribute('type', 'password');

                        // add btn eye
                        let btnEye = document.createElement('div');
                        btnEye.className = 'password__btn-eye';
                        password.append(btnEye);

                        btnEye.addEventListener('click', () => {
                            if (password.classList.contains('password--show')) {
                                input.setAttribute('type', 'password');
                                password.classList.remove('password--show');
                            } else {
                                input.setAttribute('type', 'text');
                                password.classList.add('password--show');
                            }
                        })
                    }
                })
            }
        };
        {
            let productCards = document.querySelectorAll('.product-card');
            if (productCards.length) {
                productCards.forEach(productCard => {
                    let imgWrap = productCard.querySelector('.product-card__img-wrap');
                    let bottom = productCard.querySelector('.product-card__bottom');
                    let colorPicker = productCard.querySelector('.color-picker');

                    if (imgWrap && bottom && colorPicker) {
                        const changePosition = () => {
                            if (document.documentElement.clientWidth < 768) {
                                imgWrap.after(colorPicker);
                            } else {
                                bottom.append(colorPicker);
                            }
                        }

                        changePosition();

                        window.addEventListener('resize', changePosition);
                    }
                })
            }
        };
    }

    setFullHeight() {
        let elements = document.querySelectorAll('[data-set-full-height]');
        if (elements.length) {
            let header = document.querySelector('[data-header]');
            elements.forEach(el => {
                let mob = el.dataset.setFullHeight === 'mob';

                const setHeight = () => {
                    if (mob && document.documentElement.clientWidth > 767.98) return;
                    el.style.minHeight = document.documentElement.clientHeight - header.clientHeight + 'px';
                }

                setHeight();

                window.addEventListener('resize', setHeight);
            })
        }
    }

    initDatepicker() {
        let elements = document.querySelectorAll('[data-datepicker]');
        if (elements.length) {
            elements.forEach(el => {
                let input = el.querySelector('input');
                datepicker(input, {
                    formatter: (input, date, instance) => {
                        const value = date.toLocaleDateString()
                        input.value = value
                    }
                });
            })
        }
    }

    initTooltip() {
        let elements = document.querySelectorAll('[data-tooltip]');
        if (elements.length) {
            elements.forEach(el => {
                tippy(el, {
                    content: el.dataset.tooltip,
                });
            })
        }
    }


    componentsScriptsAfterLoadPage() {
        {
            let promoTitle = document.querySelector('[data-promo-title]');
            if (promoTitle) {
                let discoverText = document.querySelector('.promo-header__title-discover');
                let mask = document.querySelector('.promo-header__title-mask');

                let x;
                let y;
                let r = 7;
                let animValue = 0;
                let borderXStart = 10;
                let borderXEnd = 100 - borderXStart;
                let borderYStart = 15;
                let borderYEnd = 100 - borderYStart;
                let animationForwardId = null;
                let animationBackId = null;

                const animationForward = () => {
                    if (animValue < r) {
                        animValue += 0.2;
                        mask.style.clipPath = `circle(${animValue}% at ${x}% ${y}%)`;
                        animationForwardId = requestAnimationFrame(animationForward);
                    }
                }

                const animationBack = () => {
                    if (animValue > 0) {
                        animValue -= 0.2;
                        mask.style.clipPath = `circle(${animValue}% at ${x}% ${y}%)`;
                        animationBackId = requestAnimationFrame(animationBack);
                    }
                }

                promoTitle.addEventListener('mousemove', (e) => {
                    if (document.documentElement.clientWidth > 991) {
                        let { left, top, width, height } = mask.getBoundingClientRect();

                        x = (e.clientX - left) / width * 100;
                        y = (e.clientY - top) / height * 100;

                        mask.style.clipPath = `circle(${animValue}% at ${x}% ${y}%)`;
                        discoverText.setAttribute('style', `left:${x}%;top:${y}%;`);

                    }
                })
                promoTitle.addEventListener('mouseenter', () => {
                    if (document.documentElement.clientWidth > 991) {
                        mask.classList.add('_anime');
                        animationForward();
                        if (animationBackId) {
                            cancelAnimationFrame(animationBackId);
                        }
                    }

                })

                promoTitle.addEventListener('mouseleave', () => {
                    if (document.documentElement.clientWidth > 991) {
                        mask.classList.remove('_anime');
                        animationBack();

                        if (animationForwardId) {
                            cancelAnimationFrame(animationForwardId);
                        }
                    }
                })
            }
        };
        {
            let sidePanelAll = Array.from(document.querySelectorAll('[data-side-panel]'));
            if (sidePanelAll.length) {
                sidePanelAll.forEach(sidePanel => {
                    sidePanel.addEventListener('click', (e) => {
                        if (e.target.closest('[data-side-panel-close]')) {
                            e.preventDefault();
                            sidePanel.classList.remove('side-panel--open');
                            document.body.classList.remove('overflow-hidden');

                        }
                    })

                    if (sidePanel.dataset.sidePanel === "basket" || sidePanel.dataset.sidePanel === "favorites") {
                        let head = sidePanel.querySelector('.side-panel__head');
                        let scrollWrap = sidePanel.querySelector('.side-panel__scroll-wrap');
                        let bottom = sidePanel.querySelector('.side-panel__bottom');

                        if (head && scrollWrap && bottom) {
                            const setHeight = () => {
                                scrollWrap.style.height = `calc(100% - ${head.clientHeight + bottom.clientHeight}px)`;
                            }
                            setHeight();

                            const setMinHeight = () => {
                                if (this.utils.isMobile()) {
                                    scrollWrap.style.minHeight = `calc(100% - ${head.clientHeight}px)`;
                                }
                            }

                            window.addEventListener('resize', setHeight);
                        }

                        let observer = new MutationObserver(mutationRecords => {
                            let head = sidePanel.querySelector('.side-panel__head');
                            let scrollWrap = sidePanel.querySelector('.side-panel__scroll-wrap');
                            let bottom = sidePanel.querySelector('.side-panel__bottom');

                            if (head && scrollWrap && bottom) {
                                const setHeight = () => {
                                    scrollWrap.style.height = `calc(100% - ${head.clientHeight + bottom.clientHeight}px)`;
                                }
                                setHeight();

                                const setMinHeight = () => {
                                    if (this.utils.isMobile()) {
                                        scrollWrap.style.minHeight = `calc(100% - ${head.clientHeight}px)`;
                                    }
                                }

                                window.addEventListener('resize', setHeight);
                            }
                        });

                        observer.observe(sidePanel, {
                            childList: true,
                            subtree: true,
                        });


                    }

                    sidePanel.addEventListener('click', (e) => {
                        if (e.target.closest('.side-panel__body')) return;

                        e.preventDefault();
                        sidePanel.classList.remove('side-panel--open');
                        document.body.classList.remove('overflow-hidden');
                    })
                })

                let openButtons = document.querySelectorAll('[data-side-panel-open]');
                if (openButtons.length) {
                    openButtons.forEach(openButton => {
                        let [sidePanel] = sidePanelAll.filter(sidePanel => sidePanel.dataset.sidePanel === openButton.dataset.sidePanelOpen);
                        openButton.addEventListener('click', (e) => {
                            e.preventDefault();
                            sidePanel.classList.add('side-panel--open');
                            document.body.classList.add('overflow-hidden');
                        })
                    })
                }
            }

            window.sidePanel = {
                open(id) {
                    let sidePanel = document.querySelector(`[data-side-panel="${id}"]`);
                    if (sidePanel) {
                        sidePanel.classList.add('side-panel--open');
                        document.body.classList.add('overflow-hidden');
                    }
                },
                close(id) {
                    let sidePanel = document.querySelector(`[data-side-panel="${id}"]`);
                    if (sidePanel) {
                        sidePanel.classList.remove('side-panel--open');
                        document.body.classList.remove('overflow-hidden');
                    }
                }
            }
        }
        ;
        {
            let rangeAll = document.querySelectorAll('[data-price-range]');
            if (rangeAll.length) {
                rangeAll.forEach(range => {
                    let min = range.dataset.min;
                    let max = range.dataset.max;
                    let numStart = range.dataset.start;
                    let numEnd = range.dataset.end;
                    let step = range.dataset.step;
                    let slider = range.querySelector('.price-range__slider');
                    let inputStart = range.querySelector('.price-range__input--start');
                    let inputEnd = range.querySelector('.price-range__input--end');

                    noUiSlider.create(slider, {
                        start: [+numStart, +numEnd],
                        connect: true,
                        range: {
                            'min': [+min],
                            'max': [+max],
                        },
                        step: +step,
                        tooltips: true,
                        format: wNumb({
                            decimals: 0
                        })
                    });

                    window.priceSlider = slider;

                    let numFormat = wNumb({ decimals: 0, thousand: ',' });

                    slider.noUiSlider.on('update', function (values, handle) {
                        let value = values[handle];
                        if (handle) {
                            inputEnd.value = Math.round(value);
                        } else {
                            inputStart.value = Math.round(value);
                        }
                    });

                    slider.noUiSlider.on('change', (values, handle) => {
                        let value = values[handle];
                        if (handle) {
                            let event = new Event("change", { bubbles: true });
                            inputEnd.dispatchEvent(event);
                        } else {
                            let event = new Event("change", { bubbles: true });
                            inputStart.dispatchEvent(event);
                        }

                        let pr = document.getElementById('priceRange');

                        pr.value = inputStart.value + ";" + inputEnd.value;

                    })

                    inputStart.addEventListener('change', function () {
                        slider.noUiSlider.set([this.value, null]);
                    });
                    inputEnd.addEventListener('change', function () {
                        slider.noUiSlider.set([null, this.value]);
                    });
                })
            }

        }
        ;
        {
            let blogList = document.querySelector('[data-blog-list]');
            if (blogList) {
                if (document.documentElement.clientWidth >= 992) {
                    let count = 1;

                    // add columns
                    const createColumn = (className) => {
                        let div = document.createElement('div');
                        div.className = className;
                        return div;
                    }
                    let columns = {
                        "1": createColumn('blog-list__column'),
                        "2": createColumn('blog-list__column'),
                        "3": createColumn('blog-list__column')
                    }
                    blogList.append(columns["1"], columns["2"], columns["3"]);


                    // move items to columns
                    Array.from(blogList.querySelectorAll('.blog-list__item')).forEach(item => {
                        columns[count].append(item);

                        if (count <= 2) {
                            count++;
                        } else {
                            count = 1;
                        }
                    })

                    // align columns
                    for (let i = 0; i < 10; i++) {
                        const getMaxHeightColumn = () => {
                            let num = 0;
                            let el;
                            Object.values(columns).forEach(item => {
                                if (item.clientHeight > num) {
                                    num = item.clientHeight;
                                    el = item;
                                }
                            })
                            return { el, height: num };
                        }

                        const getMinHeightColumn = () => {
                            let num = columns["1"].clientHeight;
                            let el = columns["1"];

                            Object.values(columns).forEach(item => {
                                if (item.clientHeight < num) {
                                    num = item.clientHeight;
                                    el = item;
                                }
                            })
                            return { el, height: num };
                        }

                        let maxHeightColumn = getMaxHeightColumn();
                        let minHeightColumn = getMinHeightColumn();

                        if (maxHeightColumn.height - minHeightColumn.height > 400) {
                            minHeightColumn.el.append(maxHeightColumn.el.lastElementChild);
                        }
                    }
                }
            }
        };
        {
            let blogDetail = document.querySelector('[data-blog-detail]');
            if (blogDetail) {
                let headImage = blogDetail.querySelector('.blog-detail__article-head-img');
                let sidePostWrap = blogDetail.querySelector('.blog-detail__col-2');

                if (headImage && sidePostWrap) {
                    sidePostWrap.style.paddingTop = headImage.offsetTop + 'px';
                }
            }
        };
        // let dropZoneBoxes = document.querySelectorAll('[data-drop-zone]');
        // if(dropZoneBoxes.length) {
        //     dropZoneBoxes.forEach(dropZoneBox => {
        //         if (dropZoneBox) {
        //             let inputFile = dropZoneBox.querySelector('.drop-zone__input');
        //             let fraction = dropZoneBox.querySelector('.drop-zone__fraction');
        //             let submitBtn = dropZoneBox.closest('form').querySelector('[type="submit"], .form__submit');

        //             let dropZone = new Dropzone(dropZoneBox, {
        //                 url: '/',
        //                 previewsContainer: dropZoneBox.querySelector('.drop-zone__preview'),
        //                 uploadMultiple: true,
        //                 maxFiles: 10,
        //                 addRemoveLinks: true,
        //                 thumbnail: function (file, dataUrl) {
        //                     if (file.previewElement) {
        //                         file.previewElement.classList.remove("dz-file-preview");
        //                         let images = file.previewElement.querySelectorAll("[data-dz-thumbnail]");
        //                         for (let i = 0; i < images.length; i++) {
        //                             let thumbnailElement = images[i];
        //                             thumbnailElement.alt = file.name;
        //                             thumbnailElement.src = dataUrl;
        //                         }
        //                         setTimeout(function () { file.previewElement.classList.add("dz-image-preview"); }, 1);
        //                     }
        //                 },
        //                 accept: function (file, done) {
        //                     if (file.type === "image/jpeg" || file.type === "image/jpg" || file.type === "image/png" || file.type === "application/pdf") {
        //                         done();
        //                     }
        //                     else {
        //                         done("Error! Files of this type are not accepted");
        //                     }
        //                 }
        //             });

        //             let minSteps = 6,
        //                 maxSteps = 60,
        //                 timeBetweenSteps = 100,
        //                 bytesPerStep = 100000;

        //             dropZone.uploadFiles = function (files) {
        //                 let self = this;

        //                 for (let i = 0; i < files.length; i++) {

        //                     let file = files[i];
        //                     let totalSteps = Math.round(Math.min(maxSteps, Math.max(minSteps, file.size / bytesPerStep)));

        //                     for (let step = 0; step < totalSteps; step++) {
        //                         let duration = timeBetweenSteps * (step + 1);
        //                         setTimeout(function (file, totalSteps, step) {
        //                             return function () {
        //                                 file.upload = {
        //                                     progress: 100 * (step + 1) / totalSteps,
        //                                     total: file.size,
        //                                     bytesSent: (step + 1) * file.size / totalSteps
        //                                 };

        //                                 self.emit('uploadprogress', file, file.upload.progress, file.upload.bytesSent);
        //                                 if (file.upload.progress == 100) {
        //                                     file.status = Dropzone.SUCCESS;
        //                                     self.emit("success", file, 'success', null);
        //                                     self.emit("complete", file);
        //                                     self.processQueue();
        //                                     //document.getElementsByClassName("dz-success-mark").style.opacity = "1";
        //                                 }
        //                             };
        //                         }(file, totalSteps, step), duration);
        //                     }
        //                 }
        //             }

        //             let dt = new DataTransfer();
        //             const numberOfFilesHandler = () => {
        //                 fraction.innerText = dt.files.length + '/10';
        //                 dropZoneBox.classList.toggle('drop-zone--has-files', dt.files.length > 0)

        //                 if(dt.files.length > 10) {
        //                     submitBtn.setAttribute('disabled', true);
        //                 } else {
        //                     submitBtn.removeAttribute('disabled');
        //                 }
        //             }

        //             dropZone.on("complete", function (file) {
        //                 // console.log(file);
        //             });

        //             dropZone.on("addedfile", file => {
        //                 dt.items.add(file)
        //                 inputFile.files = dt.files;

        //                 numberOfFilesHandler();
        //             })

        //             dropZone.on("removedfile", file => {
        //                 dt.items.remove(file)
        //                 inputFile.files = dt.files;
        //                 numberOfFilesHandler();
        //                 console.log(dt.files)
        //             })
        //         }
        //     })
        // };
        {
            let orderList = document.querySelector('[data-order-list]');
            if (orderList) {
                let items = orderList.querySelectorAll('.orders-list__item');
                if (items.length) {
                    items.forEach(item => {
                        let icon = item.querySelector('.orders-list__icon');
                        let btn = item.querySelector('.orders-list__main-info-row');
                        let collapsedRow = item.querySelector('.orders-list__detail-info-row');

                        if (btn && collapsedRow) {
                            btn.addEventListener('click', () => {
                                icon.classList.toggle('active');
                                this.utils.slideToggle(collapsedRow);

                            })
                        }
                    })
                }
            }
        };
        {
            let quantityAll = document.querySelectorAll('[data-quantity]');
            if (quantityAll.length) {
                quantityAll.forEach(quantity => {
                    let buttons = quantity.querySelectorAll('.quantity__button');
                    let input = quantity.querySelector('input');

                    if (buttons.length && input) {
                        buttons.forEach(button => {
                            button.addEventListener("click", function (e) {
                                let value = input.value;
                                if (button.classList.contains('quantity__button--plus')) {
                                    value++;
                                } else {
                                    value = value - 1;
                                    if (value < 1) {
                                        value = 1
                                    }
                                }
                                input.value = value;
                            });
                        })
                    }
                })
            }
        }
        ;
        {
            let footerAccordion = document.querySelector('[data-footer-accordion]');
            if (footerAccordion) {
                let items = footerAccordion.querySelectorAll('.footer__body-col');
                if (items.length) {
                    items.forEach(item => {
                        let trigger = item.querySelector('.footer__title-link');
                        let content = item.querySelector('.footer__list');

                        if (trigger && content) {
                            trigger.addEventListener('click', (e) => {
                                if (document.documentElement.clientWidth < 768) {
                                    e.preventDefault();
                                    trigger.classList.toggle('active');
                                    this.utils.slideToggle(content);

                                    items.forEach(i => {
                                        if (item === i) return;

                                        let trigger = i.querySelector('.footer__title-link');
                                        let content = i.querySelector('.footer__list');

                                        trigger.classList.remove('active');
                                        this.utils.slideUp(content);
                                    })

                                }
                            })
                        }
                    })
                }
            }
        };
        {
            let textTableAll = document.querySelectorAll('[data-text-table]');
            if (textTableAll.length) {
                textTableAll.forEach(textTable => {
                    let collapseBox = textTable.querySelector('.text-tabel__collapse');
                    let btn = textTable.querySelector('.link-see-more');

                    if (collapseBox && btn) {
                        let textOpen = btn.innerText;
                        let textClose = btn.dataset.text;

                        btn.addEventListener('click', (e) => {
                            e.preventDefault();
                            if (btn.classList.contains('text-is-show')) {
                                btn.classList.remove('text-is-show');
                                btn.innerText = textOpen;

                                // window.locomotivePageScroll.scrollTo(textTable, {
                                //     offset: -50,
                                //     duration: 0
                                // })

                            } else {
                                btn.classList.add('text-is-show');
                                btn.innerText = textClose;
                            }

                            this.utils.slideToggle(collapseBox);

                        })
                    }
                })
            }
        };
        {
            let mobShareBox = document.querySelector('[data-mob-share]');
            let mobShareBtn = document.querySelector('[data-action="mob-share-open"]');

            if (mobShareBox && mobShareBtn) {
                mobShareBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    mobShareBtn.classList.add('hide');
                    mobShareBox.classList.add('mob-share--open');
                    document.body.classList.add('overflow-hidden');
                })

                mobShareBox.addEventListener('click', (e) => {
                    if (e.target.closest('.mob-share__social')) return;

                    mobShareBtn.classList.remove('hide');
                    mobShareBox.classList.remove('mob-share--open');
                    document.body.classList.remove('overflow-hidden');
                })
            }
        };
        {
            let cart = document.querySelector('[data-cart]');
            if (cart) {
                let couponCheckbox = cart.querySelector('.payment-cart__coupon-checkbox input');
                let inputWrap = cart.querySelector('.payment-cart__coupon-input');
                let mobHead = cart.querySelector('.payment-cart__mob-head');
                let cartBody = cart.querySelector('.payment-cart__body');
                let btnShopingCart = cart.querySelector('.checkout-button');
                let btnCheckout = cart.querySelector('.button#place_order');

                let setPostionF = null;
                if (couponCheckbox && inputWrap) {
                    couponCheckbox.addEventListener('change', (e) => {
                        if (couponCheckbox.checked) {
                            this.utils.slideDown(inputWrap, 300);
                        } else {
                            this.utils.slideUp(inputWrap, 300);
                        }

                    })
                }

                if (mobHead && cartBody) {
                    mobHead.addEventListener('click', () => {
                        mobHead.classList.toggle('active');
                        this.utils.slideToggle(cartBody, 300);

                        let id = setInterval(() => {
                            if (setPostionF) setPostionF();
                        }, 20);
                        setTimeout(() => {
                            clearInterval(id);
                        }, 200)
                    })
                }

                if (btnShopingCart) {
                    let mainWrap = btnShopingCart.closest('.shopping-cart__body');
                    let parent = btnShopingCart.parentElement;
                    let footer = document.querySelector('.footer__inner');

                    if (footer) {
                        const setPosition = () => {
                            if (document.documentElement.clientWidth < 992) {
                                let footerTop = footer.getBoundingClientRect().top - document.documentElement.clientHeight;
                                if (footerTop > 0) {
                                    btnShopingCart.classList.add('payment-cart__submit--fixed');
                                    mainWrap.style.paddingBottom = btnShopingCart.clientHeight + 'px';
                                } else {
                                    btnShopingCart.classList.remove('payment-cart__submit--fixed');
                                    mainWrap.style.paddingBottom = '0px';
                                }
                            }
                        }

                        setPosition();
                        setPostionF = setPosition;
                        window.addEventListener('scroll', setPosition);
                    }

                    if (mainWrap) {
                        mainWrap.classList.add('overflow-visible')
                    }

                    const changePosition = () => {
                        if (document.documentElement.clientWidth < 992) {
                            mainWrap.append(btnShopingCart);
                        } else {
                            parent.append(btnShopingCart);
                        }
                    }

                    changePosition();

                    window.addEventListener('resize', changePosition);
                }

                if (btnCheckout) {
                    let parent = btnCheckout.parentElement;
                    let parentForm = btnCheckout.closest('form.checkout');

                    const setPosition = () => {
                        if (document.documentElement.clientWidth < 992) {
                            parentForm.append(btnCheckout);
                        } else {
                            parent.append(btnCheckout);
                        }
                    }

                    setPosition();

                    window.addEventListener('resize', setPosition);
                }
            }
        };
        {
            let checkout = document.querySelector('[data-checkout]');
            if (checkout) {
                // set height
                let header = document.querySelector('[data-header]')
                let footerSimple = document.querySelector('[data-footer-simple]')

                if (header && footerSimple) {
                    const setHeight = () => {
                        checkout.style.minHeight = document.documentElement.clientHeight - header.clientHeight - footerSimple.clientHeight + 'px';
                    }

                    setHeight();

                    window.addEventListener('resize', setHeight);
                }


                // step toggle handler
                let steps = Array.from(document.querySelectorAll('[data-step]'));
                if (steps.length) {
                    steps.forEach(step => {
                        let stepTrigger = step.querySelector('[data-trigger-step]');
                        let collapseContainer = step.querySelector('[data-collapse-step]');
                        let changeBtn = step.querySelector('.steps-checkout__change');

                        if (stepTrigger && collapseContainer) {
                            //init
                            if (step.classList.contains('steps-checkout__step--open')) {
                                if (collapseContainer) {
                                    collapseContainer.style.display = 'block';
                                }
                            }

                            stepTrigger.addEventListener('click', () => {
                                step.classList.toggle('steps-checkout__step--open');

                                if (collapseContainer) {
                                    this.utils.slideToggle(collapseContainer, 500);
                                }

                                steps.forEach(i => {
                                    if (step === i) return;

                                    let collapseContainer = i.querySelector('[data-collapse-step]');

                                    i.classList.remove('steps-checkout__step--open');

                                    if (collapseContainer) {
                                        this.utils.slideUp(collapseContainer, 500);
                                    }
                                })
                            })

                        }

                        if (changeBtn) {
                            changeBtn.addEventListener('click', (e) => {
                                e.preventDefault();
                                step.classList.toggle('steps-checkout__step--open');

                                if (collapseContainer) {
                                    this.utils.slideToggle(collapseContainer, 500);
                                }

                                steps.forEach(i => {
                                    if (step === i) return;

                                    let collapseContainer = i.querySelector('[data-collapse-step]');

                                    i.classList.remove('steps-checkout__step--open');

                                    if (collapseContainer) {
                                        this.utils.slideUp(collapseContainer, 500);
                                    }
                                })
                            })
                        }
                    })

                    const slideDown = (el) => {
                        this.utils.slideDown(el, 500);
                    }
                    const slideUp = (el) => {
                        this.utils.slideUp(el, 500);
                    }
                    window.checkoutSteps = {
                        openStep(id) {
                            let [step] = steps.filter(i => i.dataset.step === id);
                            if (step) {
                                let collapseContainer = step.querySelector('[data-collapse-step]');

                                step.classList.add('steps-checkout__step--open');
                                if (collapseContainer) {
                                    slideDown(collapseContainer);
                                }

                                steps.forEach(i => {
                                    if (step === i) return;

                                    let collapseContainer = i.querySelector('[data-collapse-step]');

                                    i.classList.remove('steps-checkout__step--open');

                                    if (collapseContainer) {
                                        slideUp(collapseContainer);
                                    }
                                })
                            }
                        },
                        closeStep(id) {
                            let [step] = steps.filter(i => i.dataset.step === id);
                            if (step) {
                                let collapseContainer = step.querySelector('[data-collapse-step]');

                                step.classList.remove('steps-checkout__step--open');
                                if (collapseContainer) {
                                    slideUp(collapseContainer);
                                }
                            }
                        },
                        setStepAsFilled(id) {
                            let [step] = steps.filter(i => i.dataset.step === id);
                            if (step) {
                                let subTitle = step.querySelector('.steps-checkout__subtitle');
                                let resultList = step.querySelector('.steps-checkout__result-list');

                                step.classList.add('steps-checkout__step--filled');
                                if (subTitle) {
                                    slideUp(subTitle);
                                }

                                if (resultList) {
                                    slideDown(resultList);
                                }
                            }
                        },
                        unsetStepAsFilled(id) {
                            let [step] = steps.filter(i => i.dataset.step === id);
                            if (step) {
                                let subTitle = step.querySelector('.steps-checkout__subtitle');
                                let resultList = step.querySelector('.steps-checkout__result-list');

                                step.classList.remove('steps-checkout__step--filled');
                                if (subTitle) {
                                    slideDown(subTitle);
                                }

                                if (resultList) {
                                    slideUp(resultList);
                                }
                            }
                        }
                    }
                }

                // step one handler
                const email_test = (input) => {
                    return /^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,8})$/.test(input.value);
                    
                }
                const setError = (input, text) => {
                    input.classList.add('error');
                    let label = document.createElement('label');
                    label.className = 'error';
                    label.innerText = text;
                    input.after(label);
                }
                const deletError = (input) => {
                    input.classList.remove('error');
                    let label = input.parentElement.querySelector('label.error');
                    if(label) {
                        label.remove();
                    }
                }

                const inputValidate = (input) => {
                    let validateResult = false;
                    if(input.type === 'email') {
                        if(email_test(input)) {
                            validateResult = true;
                            deletError(input);
                        } else {
                            validateResult = false;
                            setError(input, 'Incorrect E-Mail Address');
                        }
                    } else if(input.type === 'text') {
                        if(input.value.trim()) {
                            validateResult = true;
                            deletError(input);
                        } else {
                            validateResult = false;
                            setError(input, 'The field is required');
                        }
                    }
                    return validateResult;
                }

                let step1 = document.querySelector('[data-step="0"]');
                if (step1) {
                    let resultList = step1.querySelector('.steps-checkout__result-list');
                    let inputs = [
                        step1.querySelector('#billing_first_name'),
                        step1.querySelector('#billing_phone'),
                        step1.querySelector('#billing_email'),
                        step1.querySelector('#billing_city'),
                    ]

                    let results = [false, false, false, false];

                    inputs.forEach((input, index) => {
                        if (input) {
                            //init
                            if(input.value.trim()) {
                                results[index] = true;
                            }

                            input.addEventListener('focus', () => {
                                input.classList.add('visited');
                            })

                            input.addEventListener('blur', () => {
                                results[index] = inputValidate(input);

                                if (results.every(i => i === true)) {
                                    resultList.innerHTML = `<li>
                                    ${inputs[0].value.trim()}, 
                                    ${inputs[1].value.trim()}, 
                                    ${inputs[2].value.trim()}, 
                                    ${inputs[3].value.trim()} 
                                    </li>`;

                                    checkoutSteps.setStepAsFilled('0');
                                    checkoutSteps.closeStep('0');   
                                    checkoutSteps.openStep('1');  
                                }
                            })
                        }
                    })

                    if (results.every(i => i === true)) {
                        resultList.innerHTML = `<li>
                        ${inputs[0].value.trim()}, 
                        ${inputs[1].value.trim()}, 
                        ${inputs[2].value.trim()}, 
                        ${inputs[3].value.trim()} 
                        </li>`;

                        checkoutSteps.setStepAsFilled('0');
                        checkoutSteps.closeStep('0');   
                        checkoutSteps.openStep('1');  
                    }
                }

                // step two handler
                let step2 = document.querySelector('[data-step="1"]');
                if(step2) {
                    let resultList = step2.querySelector('.steps-checkout__result-list');
                    let message = step2.querySelector('.steps-checkout__message');
                    let btnNextStep = step2.querySelector('.steps-checkout__next-step');

                    let inputs = [
                        step2.querySelector('#shipping_state'),
                        step2.querySelector('#shipping_postcode'),
                    ]

                    let results = [false, false];

                    inputs.forEach((input, index) => {
                        if (input) {
                            //init
                            if(input.value.trim()) {
                                results[index] = true;
                            }

                            input.addEventListener('focus', () => {
                                input.classList.add('visited');
                            })

                            input.addEventListener('blur', () => {
                                results[index] = inputValidate(input);

                                if (results.every(i => i === true)) {
                                    this.utils.slideDown(message)  
                                }
                            })
                        }
                    })

                    btnNextStep.addEventListener('click', (e) => {
                        e.preventDefault();

                        let shipping_method_0_free_shipping1 = step2.querySelector('#shipping_method_0_free_shipping1');
                        let shipping_method_0_flat_rate2 = step2.querySelector('#shipping_method_0_flat_rate2');
                        let shipping_country = step2.querySelector('select[name="shipping_country"]');
                        let shipping_city = step2.querySelector('select[name="shipping_city"]');
                        let shipping_state = step2.querySelector('#shipping_state');

                        resultList.innerHTML = `
                        ${shipping_method_0_free_shipping1 ? `<li>${shipping_method_0_free_shipping1.parentElement.querySelector('.checkbox-radio__text').innerHTML}</li>` : ''} 
                        ${shipping_method_0_flat_rate2 ? `<li>${shipping_method_0_flat_rate2.parentElement.querySelector('.checkbox-radio__text').innerHTML}</li>` : ''} 
                        ${shipping_country ? `<li>Сountry: ${shipping_country.selectedOptions[0].innerHTML}</li>` : ''} 
                        ${shipping_city ? `<li>City: ${shipping_city.selectedOptions[0].innerHTML}</li>` : ''} 
                        ${shipping_state ? `<li>State: ${shipping_state.value.trim()}</li>` : ''} 
                        `;

                        checkoutSteps.setStepAsFilled('1');
                        checkoutSteps.closeStep('1');   
                        checkoutSteps.openStep('2'); 
                    })

                }
            }
        }

        {
            let collapseTriggers = document.querySelectorAll('[data-collapse-trigger]');
            if (collapseTriggers.length) {
                collapseTriggers.forEach(collapseTrigger => {
                    let id = collapseTrigger.dataset.collapseTrigger;
                    if (id) {
                        let collapseEl = document.querySelector(`[data-collapse="${id}"]`);

                        if (collapseEl) {
                            let input = collapseTrigger.querySelector('input');

                            if (input) {
                                // init
                                if (input.checked) {
                                    collapseEl.style.display = 'block';
                                }

                                document.addEventListener('change', (e) => {

                                    if (e.target === input) {
                                        if (input.checked) {
                                            this.utils.slideDown(collapseEl, 300);
                                        }
                                    } else {
                                        if (e.target.closest('[data-collapse]')) return;

                                        if (!input.checked) {
                                            this.utils.slideUp(collapseEl, 300);
                                        }
                                    }
                                })
                            }
                        }
                    }
                })
            }
        }
        ;
        {
            let paginations = document.querySelectorAll('.pagination');
            if (paginations.length) {
                paginations.forEach(pagination => {
                    let prev = pagination.querySelector('.prev');
                    let next = pagination.querySelector('.next');
                    let current = pagination.querySelector('.current');

                    if (prev) {
                        prev.closest('li').classList.add('prev');
                    }
                    if (next) {
                        next.closest('li').classList.add('next');
                    }
                    if (current) {
                        current.closest('li').classList.add('current');
                    }
                })
            }
        };
        {
            let faqSearch = document.querySelector('[data-faq-search]');
            if (faqSearch) {
                let btnShowFaqSearch = document.querySelector('[data-action="show-faq-search"]');
                let btnHideFaqSearch = document.querySelector('[data-action="hide-faq-search"]');

                if (btnShowFaqSearch) {
                    btnShowFaqSearch.addEventListener('click', (e) => {
                        e.preventDefault();
                        faqSearch.classList.add('faq__search--show');
                        document.body.classList.add('cover');
                        document.body.classList.add('overflow-hidden');
                    })
                }

                if (btnHideFaqSearch) {
                    btnHideFaqSearch.addEventListener('click', (e) => {
                        e.preventDefault();
                        faqSearch.classList.remove('faq__search--show');
                        document.body.classList.remove('cover');
                        document.body.classList.remove('overflow-hidden');
                    })
                }
            }
        };
        {
            let mobileBottomPrice = document.querySelector('.mobile-bottom-price');
            let btnBuyNow = document.querySelector('.product-detail-main-info__buttons .add-to-cart');
            let footer = document.querySelector('.footer__inner');

            if (mobileBottomPrice && btnBuyNow) {

                const setFooterPadding = () => {
                    if (document.documentElement.clientWidth < 768) {
                        footer.style.paddingBottom = mobileBottomPrice.clientHeight + 'px';
                    } else {
                        footer.style.paddingBottom = '0px';
                    }
                }

                setFooterPadding();

                window.addEventListener('resize', setFooterPadding);

                window.addEventListener('scroll', (e) => {
                    if (btnBuyNow.getBoundingClientRect().top > 0 && btnBuyNow.getBoundingClientRect().top < document.documentElement.clientHeight) {
                        mobileBottomPrice.classList.add('hide')
                    } else {
                        mobileBottomPrice.classList.remove('hide')
                    }
                })
            }
        }

        {
            let lastSection = document.querySelector('[data-last-section]');
            let footer = document.querySelector('.footer');
            if (lastSection && footer) {
                footer.style.paddingTop = '0px';
            }
        }


    }

    initConstructorScripts() {
        {
            let ratings = document.querySelectorAll('[data-rating]');
            if (ratings.length) {
                ratings.forEach(rating => {
                    let count = rating.dataset.rating > 5 ? 5
                        : rating.dataset.rating ? rating.dataset.rating
                            : 0;

                    let starsLine = rating.querySelector('.rating__stars-1');

                    starsLine.style.width = `calc(${count / 5 * 100}% - ${0.3}rem)`;
                })
            }
        };
        let colorPickers = document.querySelectorAll('[data-color-picker]');
        if (colorPickers.length) {
            colorPickers.forEach(colorPicker => {
                let colorNameEl = document.querySelector(`[data-color-picker-color-name="${colorPicker.dataset.colorPicker}"]`);
                if (colorNameEl) {
                    // init
                    let activeEl = colorPicker.querySelector('.color-picker__item--active[data-color-picker-set-color-name]');
                    if (activeEl) {
                        if (activeEl.dataset.colorPickerSetColorName) {
                            colorNameEl.innerHTML = activeEl.dataset.colorPickerSetColorName;
                        }
                    }

                    // handler
                    let items = colorPicker.querySelectorAll('[data-color-picker-set-color-name]');
                    if (items.length) {
                        items.forEach(item => {
                            item.addEventListener('mouseenter', () => {
                                if (item.dataset.colorPickerSetColorName) {
                                    colorNameEl.innerHTML = item.dataset.colorPickerSetColorName;
                                }
                            })
                        })
                    }

                    colorPicker.addEventListener('mouseleave', () => {
                        if (activeEl) {
                            if (activeEl.dataset.colorPickerSetColorName) {
                                colorNameEl.innerHTML = activeEl.dataset.colorPickerSetColorName;
                            }
                        }
                    })
                }
            })
        };
        let detailSlider = document.querySelector('[data-slider="product-detail-slider"]');
        if (detailSlider) {
            let thumbSlider = new Swiper(detailSlider.querySelector('.product-detail-slider__thumb'), {
                observer: true,
                observeParents: true,
                slidesPerView: 'auto',
                spaceBetween: 12,
                speed: 600,
            });

            let mainSliderlet = new Swiper(detailSlider.querySelector('.product-detail-slider__main'), {
                observer: true,
                observeParents: true,
                slidesPerView: 1,
                spaceBetween: 20,
                speed: 600,
                watchOverflow: true,
                pagination: {
                    el: detailSlider.querySelector('.swiper-pagination'),
                    clickable: true,
                },
                navigation: {
                    nextEl: detailSlider.querySelector('.product-detail-slider__btn.btn-next'),
                    prevEl: detailSlider.querySelector('.product-detail-slider__btn.btn-prev'),
                },
                watchSlidesVisibility: true,
                thumbs: {
                    swiper: thumbSlider,
                },
            });
        };
        let models = document.querySelectorAll('[data-model]');
        if (models.length) {
            models.forEach(model => {
                let modelNameEl = document.querySelector(`[data-model-name="${model.dataset.model}"]`);
                if (modelNameEl) {
                    // init
                    let activeEl = model.querySelector('.model__item--active[data-model-set-name]');
                    if (activeEl) {
                        if (activeEl.dataset.modelSetName) {
                            modelNameEl.innerHTML = activeEl.dataset.modelSetName;
                        }
                    }

                    // handler
                    let items = model.querySelectorAll('[data-model-set-name]');
                    if (items.length) {
                        items.forEach(item => {
                            item.addEventListener('mouseenter', () => {
                                if (item.dataset.modelSetName) {
                                    modelNameEl.innerHTML = item.dataset.modelSetName;
                                }
                            })
                        })
                    }

                    model.addEventListener('mouseleave', () => {
                        if (activeEl) {
                            if (activeEl.dataset.modelSetName) {
                                modelNameEl.innerHTML = activeEl.dataset.modelSetName;
                            }
                        }
                    })
                }
            })
        };
    }

    scrollTriggerAnimation() {
        function scrollTrigger(el, value, callback) {
            let triggerPoint = document.documentElement.clientHeight / 100 * (100 - value);
            const trigger = () => {
                if (el.getBoundingClientRect().top <= triggerPoint && !el.classList.contains('is-show')) {
                    if (typeof callback === 'function') {
                        callback();
                        el.classList.add('is-show')
                    }
                }
            }

            trigger();

            window.addEventListener('scroll', trigger);
        }

        let elements = document.querySelectorAll('[data-scroll]');
        if (elements.length) {
            elements.forEach(item => {
                window.addEventListener('load', () => {
                    scrollTrigger(item, 15, () => {
                        item.classList.add('is-inview');
                    })
                })
            })
        }
    }

    initScrollSticky() {
        let stickyElements = document.querySelectorAll('[data-scroll-sticky]');
        if (stickyElements.length) {
            stickyElements.forEach(el => {
                el.closest('._page').classList.add('overflow-visible');
            })
        }
    }

}

window.addEventListener('DOMContentLoaded', function () {
    let app = new App();
    app.init();

    window.app = app;
});


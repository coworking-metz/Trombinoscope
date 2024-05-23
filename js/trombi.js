(() => {
    // document.querySelectorAll('.user').forEach(user => user.classList.add('loading'));

    document.addEventListener('DOMContentLoaded', () => {
        updateTimeInFrance();
        // window.addEventListener('load', () => {
        //     document.querySelectorAll('.user .image.big').forEach(user => user.classList.add('ready'));
        //     setTimeout(() => {

        //         document.querySelectorAll('.user.loading').forEach(user => setTimeout(() => user.classList.remove('loading'), randomTime()));
        //     }, 1000);
        // })

        // document.querySelectorAll('.image.big').forEach(image => {
        //     image.addEventListener('load', function () {
        //         image.closest('.user').classList.remove('loading');
        //     })
        // });
        if (document.body.dataset.admin == 'true') return;
        if (isMobile()) return;
        document.querySelectorAll('.users figure').forEach(user => {
            const vitesse = randomTime() / 10;
            setTimeout(() => {
                setInterval(() => {
                    const angle = randomAngle();
                    const style = [];
                    style.push(`transition: all ${vitesse}ms ease`);
                    style.push(`transform: rotate(${angle}deg)`);
                    user.setAttribute('style', style.join(';'))
                }, randomTime() + 2000)
            }, randomTime());

        })
    })
    function isMobile() {
        const style = window.getComputedStyle(document.body);
        const contentValue = style.getPropertyValue('content');
        return contentValue.includes('mobile');
    }
    function randomTime() {
        return Math.floor(Math.random() * (3000 - 1000 + 1)) + 1000;
    }
    function randomAngle() {
        return randomSignFlip(getRandomNumber());
    }
    function getRandomNumber() {
        return Math.floor(Math.random() * 7) + 1.5;
    }
    function randomSignFlip(num) {
        return Math.random() < 0.5 ? -num : num;
    }
    function updateTimeInFrance() {
        const timeElements = document.querySelectorAll('time');
        setInterval(() => {
            const now = new Date();
            const formatter = new Intl.DateTimeFormat('en-GB', {
                timeZone: 'Europe/Paris',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: false
            });
            const timeString = formatter.format(now);
            timeElements.forEach(timeElement => {
                timeElement.classList.remove('loading')
                timeElement.innerHTML = timeString.split(':').map(str => '<span>' + str + '</span>').join(':');
            });
        }, 1000);
    }



})();


const getUncomputedValue = (target, elem = false) => {
    let element = document.querySelector(elem);

    if (!element) {
        element = document.documentElement;
    }

    const styleValue = getComputedStyle(element).getPropertyValue(target);
    console.log(styleValue)
    if (!styleValue) {
        return;
    }

    const allStyling = Array.from(element.computedStyleMap()).filter(([prop, val]) => prop.includes('--') && val[0].toString().includes(styleValue));

    return allStyling.map((style) => `var(${style[0]})`).join(',');
};
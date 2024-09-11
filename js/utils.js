

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

function getCurrentDate() {
    const now = new Date();
    const year = now.getFullYear(); // Get the current year.
    const month = String(now.getMonth() + 1).padStart(2, '0'); // Get the current month, add 1 because JavaScript months are 0-indexed.
    const day = String(now.getDate()).padStart(2, '0'); // Get the current day, pad with zero if necessary.

    return `${year}-${month}-${day}`;
}

function getCurrentTime() {
    const now = new Date();
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    return `${hours}:${minutes}`;
  }

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

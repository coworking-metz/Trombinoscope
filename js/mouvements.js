document.addEventListener('DOMContentLoaded', () => {
    updateTimeInFrance();
    if (document.body.dataset.admin == 'true') return;
    if (isMobile()) return;
    document.querySelectorAll('.users .user:not(:has(.qr)) figure').forEach(user => {
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

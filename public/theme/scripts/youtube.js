const elements = document.querySelectorAll('.youtube');

// Replace YouTube video placeholders with YouTube embeds when they are clicked
elements.forEach((element) => {
  element.addEventListener('click', () => {
    const youtubeId = element.dataset.youtubeId;

    // Load YouTube embed without cookies and with autoplay
    let video = Object.assign(document.createElement('iframe'), {
      src: `https://www.youtube-nocookie.com/embed/${youtubeId}?autoplay=1&enablejsapi=1&rel=0`,
    });

    video.setAttribute(
      'allow',
      'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share',
    );
    video.setAttribute('allowfullscreen', '');
    video.setAttribute('class', 'w-full h-full');
    video.setAttribute('frameborder', '0');
    video.setAttribute('loading', 'lazy');
    video.setAttribute('referrerpolicy', 'strict-origin-when-cross-origin');

    element.replaceWith(video);
  });
});

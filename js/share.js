document.querySelectorAll('.product-card').forEach(card => {
  const productLink = card.querySelector('.product-link').href;
  const productTitle = card.querySelector('.product-title').innerText;
  const encodedLink = encodeURIComponent(productLink);
  const encodedTitle = encodeURIComponent(productTitle);

  card.querySelector('.share-whatsapp').addEventListener('click', e => {
    e.preventDefault();
    window.open(`https://api.whatsapp.com/send?text=${encodedTitle}%20${encodedLink}`, '_blank');
  });

  card.querySelector('.share-facebook').addEventListener('click', e => {
    e.preventDefault();
    window.open(`https://www.facebook.com/sharer/sharer.php?u=${encodedLink}`, '_blank');
  });

  card.querySelector('.share-twitter').addEventListener('click', e => {
    e.preventDefault();
    window.open(`https://twitter.com/intent/tweet?text=${encodedTitle}&url=${encodedLink}`, '_blank');
  });
});

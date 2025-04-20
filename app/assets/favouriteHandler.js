const btns = document.querySelectorAll('.favouriteBtn');
const favouriteLink = document.getElementById('favouriteLink');
const favourites = new Set(JSON.parse(localStorage.getItem('favourites') || '[]'));
const isFavouritesPage = window.location.href.includes('/recipe/favourites');

const TEXT_ADD = '❤️ Add to Favourites ❤️';
const TEXT_REMOVE = '🤍 Remove from Favourites 🤍';

const toggleFavourites = (id) => {
    const wasInFavourites = favourites.has(id);

    if (wasInFavourites) {
        favourites.delete(id);
    } else {
        favourites.add(id);
    }

    localStorage.setItem('favourites', JSON.stringify([...favourites]));

    if (isFavouritesPage && wasInFavourites) {
        window.location.href = prepareUrl();
    }
};

const handleUI = (btn) => {
    const id = btn.dataset.id;
    btn.innerText = favourites.has(id) ? TEXT_REMOVE : TEXT_ADD;
};

btns.forEach((btn) => {
    btn.addEventListener('click', function() {
        const id = this.dataset.id;
        toggleFavourites(id);
        handleUI(this);
    });

    handleUI(btn);
});

const prepareUrl = () => {
    const baseUrl = favouriteLink.getAttribute('href');
    const params = [...favourites].map((id, index) => `favourites[${index}]=${id}`).join('&');

    return params ? `${baseUrl}${baseUrl.includes('?') ? '&' : '?'}${params}` : `${baseUrl}?favourites[]`;
}

favouriteLink.addEventListener('click', function(event) {
    event.preventDefault();
    window.location.href = prepareUrl();
});

export { favourites, btns, prepareUrl, favouriteLink };

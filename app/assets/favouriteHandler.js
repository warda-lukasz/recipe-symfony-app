const btns = document.querySelectorAll('.favouriteBtn');
const favourites = new Set(JSON.parse(localStorage.getItem('favourites') || '[]'));

const TEXT_ADD = '❤️ Add to Favourites ❤️';
const TEXT_REMOVE = '🤍 Remove from Favourites 🤍';

const toggleFavourites = (id) => {
    if (favourites.has(id)) {
        favourites.delete(id);
    } else {
        favourites.add(id);
    }

    localStorage.setItem('favourites', JSON.stringify([...favourites]));
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

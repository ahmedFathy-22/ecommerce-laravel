function showToast(message) {
    const toast = document.getElementById("toast");

    if (!toast) return;

    toast.innerText = message;

    toast.classList.add("show");

    setTimeout(() => {
        toast.classList.remove("show");
    }, 2000);
}

function autoHideMessage(id) {
    const msg = document.getElementById(id);

    if (!msg) return;

    setTimeout(() => {
        msg.style.opacity = "0";

        setTimeout(() => {
            msg.remove();
        }, 500);

    }, 2000);
}

function addToCart(productId) {

    fetch("/cart/add", {

        method: "POST",

        headers: {
            "Content-Type": "application/json",

            "X-CSRF-TOKEN":
                document.querySelector('meta[name="csrf-token"]').content,
        },

        body: JSON.stringify({
            product_id: productId,
        }),

    })
        .then((res) => res.json())

        .then((data) => {

            showToast("✅ Added To Cart");

            const cartCount = document.getElementById("cart-count");

            if (cartCount) {
                cartCount.innerText = data.count;
            }
        })

        .catch((err) => {
            console.log(err);
        });
}

/*
|--------------------------------------------------------------------------
| Live Search
|--------------------------------------------------------------------------
*/

const searchInput = document.getElementById("search-input");

const resultsBox = document.getElementById("search-results");

let timeout = null;

if (searchInput && resultsBox) {

    searchInput.addEventListener("keyup", function () {

        clearTimeout(timeout);

        const query = this.value.trim();

        if (query.length < 2) {

            resultsBox.style.display = "none";

            resultsBox.innerHTML = "";

            return;
        }

        resultsBox.style.display = "block";

        resultsBox.innerHTML = `
            <div class="search-loading">
                🔍 Searching products...
            </div>
        `;

        timeout = setTimeout(() => {

            fetch(`/search-live?q=${query}`)

                .then((res) => res.json())

                .then((data) => {

                    if (data.length === 0) {

                        resultsBox.innerHTML = `
                            <div class="search-empty">
                                No products found 😢
                            </div>
                        `;

                        return;
                    }

                    let html = "";

                    data.forEach((item) => {

                        html += `
                            <a href="/products/${item.id}" class="search-item">

                                <img
                                    src="/${item.image}"
                                    class="search-item-image"
                                >

                                <div>

                                    <div class="search-item-title">
                                        ${item.name}
                                    </div>

                                    <small class="search-item-price">
                                        ${item.price} $
                                    </small>

                                </div>

                            </a>
                        `;
                    });

                    resultsBox.innerHTML = html;
                })

                .catch(() => {

                    resultsBox.innerHTML = `
                        <div class="search-error">
                            Error loading results
                        </div>
                    `;
                });

        }, 300);
    });
}

document.addEventListener("click", function (e) {

    if (
        searchInput &&
        resultsBox &&
        !searchInput.contains(e.target) &&
        !resultsBox.contains(e.target)
    ) {
        resultsBox.style.display = "none";
    }
});

autoHideMessage("success-msg");

autoHideMessage("error-msg");

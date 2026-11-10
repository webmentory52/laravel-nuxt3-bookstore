import type {CartItem} from "~/inc/types.ts";

const cart = ref<CartItem[]>([]);

export const useCart = () => {
    function addToCart(book: any) {
        const existing = cart.value.find(
            item => item.book_id === book.id
        )

        if (existing) {
            existing.quantity++
        } else {
            cart.value.push({
                book_id: book.id,
                title: book.title,
                slug: book.slug,
                price: Number(book.price),
                cover_image: book.cover_image,
                quantity: 1,
            })
        }

        updateLocalStorage();
    }

    function updateQuantity(bookId: number, quantity: number) {
        const item = cart.value.find(
            item => item.book_id === bookId
        )

        if (item && quantity >= 1) {
            item.quantity = quantity
        }

        updateLocalStorage();
    }

    function removeFromCart(bookId: number) {
        cart.value = cart.value.filter(
            item => item.book_id !== bookId
        )

        updateLocalStorage();
    }

    function clearCart() {
        cart.value = [];

        updateLocalStorage();
    }

    const cartCount = computed(() =>
        cart.value.reduce(
            (total, item) => total + item.quantity,
            0
        )
    )

    const cartTotal = computed(() =>
        cart.value.reduce(
            (total, item) => total + item.price * item.quantity,
            0
        )
    )

    const updateLocalStorage = () => {
        localStorage.setItem('bookstore_cart', JSON.stringify(cart.value))
    }

    onMounted(() => {
        const savedCart = localStorage.getItem('bookstore_cart')
        if (savedCart) {
            cart.value = JSON.parse(savedCart)
        }
    })

    return {
        cart,
        cartCount,
        cartTotal,
        addToCart,
        updateQuantity,
        removeFromCart,
        clearCart,
    }
}
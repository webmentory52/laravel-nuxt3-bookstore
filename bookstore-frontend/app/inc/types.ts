export type Category = {
    id?: number
    name: string
    slug: string
}

export type Book = {
    id: number
    title: string
    slug: string
    author: string
    price: string
    cover_image: string | null
    category: Category
}

export interface CartItem {
    book_id: number
    title: string
    slug: string
    price: number
    cover_image: string | null
    quantity: number
}
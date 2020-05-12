// const Example = () => import('../components/ExampleComponent');
const Product = () => import('../components/Product');
const Products = () => import('../components/Products');
const Cart=() => import('../components/Cart');


const routes = [
    {
        path: "/",
        name: "products",
        component: Products,
    },
    {
        path: "/product/:productId",
        name: "product",
        component: Product,
    },
    {
        path:"/cart",
        name: "Cart",
        component: Cart,
    }
    
]

export default routes;
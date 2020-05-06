// const Example = () => import('../components/ExampleComponent');
const Product = () => import('../components/Product');
const Products = () => import('../components/Products');

const routes = [
    {
        path: "/",
        name: "products",
        component: Products,
    },
    {
        path: "/product",
        name: "product",
        component: Product,
    },
    
]

export default routes;
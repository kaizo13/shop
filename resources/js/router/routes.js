const Example = () => import('../components/ExampleComponent');
const Product = () => import('../components/Product');

const routes = [
    {
        path: "/",
        name: "home",
        component: Example,
    },
    {
        path: "/product",
        name: "product",
        component: Product,
    },
]

export default routes;
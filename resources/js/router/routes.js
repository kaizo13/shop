const Example = () =>  ('../components/ExampleComponent');
const Product = () => import ('../components/Product');

const routes=[
    {
        path:"/product",
        name:"product",
        component:Product,
    },
]

export default routes;
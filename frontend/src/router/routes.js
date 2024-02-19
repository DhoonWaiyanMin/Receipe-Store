import HomeVue from '../pages/Home.vue'
import Detail from '../pages/Detail.vue'
import AddNewReceipe from '../pages/AddNewReceipe.vue'

const routes = [
    {
        path : "/",
        component : HomeVue,
        name : "home"
    },
    {
        path : "/detail/:id",
        component : Detail,
        name : "detail"
    },
    {
        path : "/receipes/create",
        component : AddNewReceipe,
        name : "add",
        children : [
            {
                path : "/edit/:id",
                component : AddNewReceipe,
                name : "edit"
            }
        ]
    }

]


export default routes;
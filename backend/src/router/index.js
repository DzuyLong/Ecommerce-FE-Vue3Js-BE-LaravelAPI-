import { createRouter, createWebHistory } from 'vue-router';
import Dashboard from '../views/dashboard.vue';
import Login from '../views/login.vue';
import store from '../store';
import Products from "../views/Product/Products.vue";
import AppLayout from '../components/AppLayout.vue';
import NotFound from '../views/NotFound.vue';
import Register from '../views/Register.vue';
import HomePageLayout from '../components/HomePageLayout.vue';
import ProductCategory from '../views/Product_category/ProductCategory.vue';
import ProductInventory from '../views/Product_inventory/ProductInventory.vue';
import ProductContent from '../views/WebHomePage/contentsite/ProductContent.vue';
import SingleCategory  from '../views/WebHomePage/contentsite/SingleCategory.vue';
import LoginCustomer  from '../views/WebHomePage/logincustomer/LoginCustomer.vue';
import RegisterCustomer  from '../views/WebHomePage/logincustomer/RegisterCustomer.vue';
import Cart from '../components/Cart.vue';
import ProductDetails from '../views/WebHomePage/productdetails/ProductDetails.vue';
import CustomerProfileLayout from '../components/CustomerProfileLayout.vue';
import Profile from '../views/Customer_profile/Profile.vue';
import  Address_Customer from '../views/Customer_profile/Address_Customer.vue';
    const routes = [
          {
            path: '/admin',
            name: 'admin',
            redirect: '/admin/dashboard',
            component: AppLayout,
            meta: {
              requiresAuth: true
            },
            children: [
              {
                path: 'dashboard',
                name: 'admin.dashboard',
                component: Dashboard
              },
              {
                path: 'products',
                name: 'admin.products',
                component: Products
              },
              {
                path: 'product-category',
                name: 'admin.productCategory',
                component: ProductCategory,
              },
              {
                path: 'product-inventory',
                name: 'admin.productInventory',
                component: ProductInventory,
              },                    
              
            ]
          },
        
          {
            path: '/admin/login',
            name: 'admin.login',
            component: Login,
            meta: {
              requiresGuest: true
            }
          }, 
          {
            path: '/admin/register',
            name: 'admin.register',
            component: Register,
            meta: {
              requiresGuest: true
            }
          },                    
        
          { 
            path: '/',
            name: 'homepage',
            component: HomePageLayout,
            meta: {
              AuthHomepage: true,
            },   
            children: [
              {
                path: '/',
                name: 'ProductContent',
                component: ProductContent
              },
              {
                path: '/san-pham-:slug',
                name: 'SingleCategory',
                component: SingleCategory
              },
            ]
            
          },
          {
            path: '/cart',
            name: 'cartDetails',
            component: Cart,
          },

          {
            path: '/customer',
            name: 'customer',
            redirect: '/customer/profile',
            component: CustomerProfileLayout,
            
            children: [
              {
                path: 'profile',
                name: 'customer.profile',
                component: Profile
              },
              {
                path: 'address',
                name: 'customer.address',
                component: Address_Customer
              },
                      
            ]
          },










          {
            path: '/:slug',
            name: 'ProductDetails',
            component: ProductDetails,        
            meta: {
              AuthCustomer: false
            }       
          },
          {
            path: '/login',
            name: 'login',
            component: LoginCustomer,        
            meta: {
              AuthCustomer: false
            }       
          },
          {
            path: '/register',
            name: 'register',
            component: RegisterCustomer,  
            meta: {
              AuthCustomer: false
            }  
          },
        //   {
        //     path: '/request-password',
        //     name: 'requestPassword',
        //     component: RequestPassword,
        //     meta: {
        //       requiresGuest: true
        //     }
        //   },
        //   {
        //     path: '/reset-password/:token',
        //     name: 'resetPassword',
        //     component: ResetPassword,
        //     meta: {
        //       requiresGuest: true
        //     }
        //   },
          {
            path: '/:pathMatch(.*)',
            name: 'notfound',
            component: NotFound,
          }
    ];


const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth && !store.state.user.token) {
      next({name: 'admin.login'})
    } else if (to.meta.requiresGuest && store.state.user.token) {
      next({name: 'admin.dashboard'})
    }else {
      next();
    }
  
    // if (to.meta.AuthHomepage && !store.state.customer.token) {
    //   next()
    // }else {
    //   next();
    // }


  })
  
export default router;
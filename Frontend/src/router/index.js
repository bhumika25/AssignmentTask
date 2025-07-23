import { createRouter, createWebHistory } from 'vue-router';
import DashboardView from '../views/DashboardView.vue';
import PoliciesView from '../views/PoliciesView.vue';
import PolicyCharts from '../views/PolicyCharts.vue';


const routes = [
  { path: '/', component: DashboardView },
  { path: '/policies', component: PoliciesView },
  { path: '/charts', component: PolicyCharts},
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;

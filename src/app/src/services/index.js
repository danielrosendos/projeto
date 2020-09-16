import vue from 'vue';

import serviceAuth from '@/components/auth/services';
import serviceRegister from '@/components/register/services';
import coreServices from '@/components/core/services';
import serviceDashboard from '@/components/dashboard/services';

vue.prototype.$serviceAuth = serviceAuth;
vue.prototype.$coreServices = coreServices;
vue.prototype.$serviceRegister = serviceRegister;
vue.prototype.$serviceDashboard = serviceDashboard;

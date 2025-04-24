import React from 'react';
import { NavLink, useLocation } from 'react-router-dom';
import { motion, AnimatePresence } from 'framer-motion';
import { 
  LayoutDashboard, Building2, BarChart3, FileText, Settings,
  Users, Database, TrendingUp, Award, AlertTriangle, PieChart,
  Activity, Target, Briefcase, ArrowUpRight
} from 'lucide-react';

const Sidebar = ({ isOpen, isAdmin = false }) => {
  const location = useLocation();
  
  // Navigation items with dropdown support
  const navItems = [
    { 
      name: 'Dashboard', 
      path: '/', 
      icon: <LayoutDashboard className="h-5 w-5" />,
      exact: true
    },
    { 
      name: 'Startups', 
      path: '/startups', 
      icon: <Building2 className="h-5 w-5" />,
      exact: false
    },
    { 
      name: 'Analytics', 
      path: '/analytics', 
      icon: <BarChart3 className="h-5 w-5" />,
      exact: true
    },
    { 
      name: 'Reports', 
      path: '/reports', 
      icon: <FileText className="h-5 w-5" />,
      exact: true 
    },
    { 
      name: 'Settings', 
      path: '/settings', 
      icon: <Settings className="h-5 w-5" />,
      exact: true
    }
  ];
  
  // Admin only navigation items
  const adminNavItems = [
    { 
      name: 'User Management', 
      path: '/admin/users', 
      icon: <Users className="h-5 w-5" />,
      exact: true
    },
    { 
      name: 'Database', 
      path: '/admin/database', 
      icon: <Database className="h-5 w-5" />,
      exact: true
    }
  ];

  // Sidebar animation variants
  const sidebarVariants = {
    open: {
      x: 0,
      width: 256,
      transition: {
        type: 'spring',
        stiffness: 300,
        damping: 30
      }
    },
    closed: {
      x: -256,
      width: 0,
      transition: {
        type: 'spring',
        stiffness: 300,
        damping: 30
      }
    }
  };

  // Quick stats data
  const quickStats = [
    {
      icon: <Activity className="h-5 w-5 text-indigo-600" />,
      title: "Active Startups",
      value: "2,451",
      trend: "up",
      trendValue: "+12.5%"
    },
    {
      icon: <Target className="h-5 w-5 text-green-600" />,
      title: "Success Rate",
      value: "68%",
      trend: "up",
      trendValue: "+5.2%"
    },
    {
      icon: <Briefcase className="h-5 w-5 text-purple-600" />,
      title: "Total Funding",
      value: "₹2.8B",
      trend: "up",
      trendValue: "+28.4%"
    }
  ];

  // Statistic Card Component
  const StatCard = ({ icon, title, value, trend, trendValue }) => (
    <div className="px-4 py-3 bg-gradient-to-br from-white/40 to-white/10 backdrop-blur-md rounded-lg shadow-sm border border-white/20 mb-2">
      <div className="flex items-start">
        <div className="bg-indigo-600/10 p-2 rounded-lg">
          {icon}
        </div>
        <div className="ml-3 flex-1">
          <p className="text-xs font-medium text-gray-600 dark:text-gray-300">{title}</p>
          <p className="text-lg font-bold text-gray-900 dark:text-white">{value}</p>
          {trend && (
            <div className={`flex items-center text-xs ${trend === 'up' ? 'text-green-600' : 'text-red-600'}`}>
              {trend === 'up' ? <ArrowUpRight className="h-3 w-3 mr-1" /> : <AlertTriangle className="h-3 w-3 mr-1" />}
              <span>{trendValue}</span>
            </div>
          )}
        </div>
      </div>
    </div>
  );

  return (
    <AnimatePresence>
      {isOpen && (
        <motion.aside
          variants={sidebarVariants}
          initial="closed"
          animate="open"
          exit="closed"
          className="fixed left-0 top-16 h-[calc(100vh-64px)] bg-white/80 dark:bg-gray-900/80 backdrop-blur-md border-r border-gray-200/50 dark:border-gray-700/30 w-64 overflow-hidden z-20"
        >
          <div className="h-full flex flex-col">
            <div className="flex-1 overflow-y-auto p-4">
              {/* Quick Stats */}
              <div className="mb-6">
                <h3 className="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Quick Stats</h3>
                {quickStats.map((stat, index) => (
                  <StatCard key={index} {...stat} />
                ))}
              </div>

              {/* Navigation */}
              <nav className="space-y-1">
                {navItems.map((item) => (
                  <NavLink
                    key={item.path}
                    to={item.path}
                    end={item.exact}
                    className={({ isActive }) =>
                      `flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors ${
                        isActive
                          ? 'bg-indigo-600 text-white'
                          : 'text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-indigo-900/50'
                      }`
                    }
                  >
                    <span className="mr-3">{item.icon}</span>
                    <span>{item.name}</span>
                  </NavLink>
                ))}

                {/* Admin Section */}
                {isAdmin && (
                  <>
                    <div className="pt-4 mt-4 border-t border-gray-200 dark:border-gray-700">
                      <h3 className="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                        Admin
                      </h3>
                      {adminNavItems.map((item) => (
                        <NavLink
                          key={item.path}
                          to={item.path}
                          end={item.exact}
                          className={({ isActive }) =>
                            `flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors ${
                              isActive
                                ? 'bg-indigo-600 text-white'
                                : 'text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-indigo-900/50'
                            }`
                          }
                        >
                          <span className="mr-3">{item.icon}</span>
                          <span>{item.name}</span>
                        </NavLink>
                      ))}
                    </div>
                  </>
                )}
              </nav>
            </div>

            {/* Footer */}
            <div className="p-4 border-t border-gray-200 dark:border-gray-700">
              <div className="bg-indigo-50 dark:bg-indigo-900/50 rounded-lg p-3">
                <div className="flex items-center">
                  <Award className="h-6 w-6 text-indigo-600 dark:text-indigo-400" />
                  <div className="ml-3">
                    <p className="text-sm font-medium text-gray-900 dark:text-white">Pro Features</p>
                    <p className="text-xs text-gray-500 dark:text-gray-400">Unlock advanced analytics</p>
                  </div>
                </div>
                <button className="mt-2 w-full bg-indigo-600 text-white text-sm font-medium py-1.5 px-3 rounded-lg hover:bg-indigo-700 transition-colors">
                  Upgrade Now
                </button>
              </div>
            </div>
          </div>
        </motion.aside>
      )}
    </AnimatePresence>
  );
};

export default Sidebar;
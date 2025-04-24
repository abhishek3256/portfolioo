import React, { useState, useEffect, useRef } from 'react';
import { Link, useNavigate } from 'react-router-dom';
import { useAuth } from '../contexts/AuthContext';
import { motion } from 'framer-motion';
import { 
  Search, Bell, BarChart3, Menu, X, User, LogOut, Settings,
  ChevronDown, Sun, Moon, Laptop 
} from 'lucide-react';

const Navbar = ({ toggleSidebar }) => {
  const { user, logout } = useAuth();
  const navigate = useNavigate();
  const [isProfileOpen, setIsProfileOpen] = useState(false);
  const [isNotificationOpen, setIsNotificationOpen] = useState(false);
  const [isSearchOpen, setIsSearchOpen] = useState(false);
  const [theme, setTheme] = useState('light');
  const [searchQuery, setSearchQuery] = useState('');
  const profileRef = useRef(null);
  const notificationRef = useRef(null);
  
  // Theme toggle
  const toggleTheme = (selectedTheme) => {
    setTheme(selectedTheme);
    if (selectedTheme === 'dark') {
      document.documentElement.classList.add('dark');
    } else if (selectedTheme === 'light') {
      document.documentElement.classList.remove('dark');
    } else if (selectedTheme === 'system') {
      if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
        document.documentElement.classList.add('dark');
      } else {
        document.documentElement.classList.remove('dark');
      }
    }
  };

  // Close dropdowns when clicking outside
  useEffect(() => {
    const handleClickOutside = (event) => {
      if (profileRef.current && !profileRef.current.contains(event.target)) {
        setIsProfileOpen(false);
      }
      if (notificationRef.current && !notificationRef.current.contains(event.target)) {
        setIsNotificationOpen(false);
      }
    };

    document.addEventListener('mousedown', handleClickOutside);
    return () => {
      document.removeEventListener('mousedown', handleClickOutside);
    };
  }, []);

  // Handle logout
  const handleLogout = async () => {
    await logout();
    navigate('/login');
  };

  // Handle search
  const handleSearch = (e) => {
    e.preventDefault();
    if (searchQuery.trim()) {
      navigate(`/startups?search=${encodeURIComponent(searchQuery)}`);
      setSearchQuery('');
      setIsSearchOpen(false);
    }
  };

  // Mock notifications
  const notifications = [
    { id: 1, message: 'New startup registered: TechInnovate', time: '10 minutes ago', read: false },
    { id: 2, message: 'Funding round updated for EcoSolutions', time: '1 hour ago', read: false },
    { id: 3, message: 'Report generation completed', time: '3 hours ago', read: true },
  ];

  return (
    <nav className="bg-gradient-to-r from-indigo-600 to-purple-600 text-white backdrop-blur-lg bg-opacity-80 border-b border-indigo-700/50 sticky top-0 z-30">
      <div className="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex justify-between h-16">
          <div className="flex items-center">
            {/* Mobile menu button */}
            <button
              onClick={toggleSidebar}
              className="p-2 rounded-md text-white hover:bg-indigo-500 hover:bg-opacity-50 focus:outline-none"
            >
              <Menu className="h-6 w-6" />
            </button>
            
            {/* Logo */}
            <Link to="/" className="flex items-center ml-2 md:ml-4">
              <BarChart3 className="h-8 w-8 text-white" />
              <span className="ml-2 text-xl font-bold hidden md:block">Startup India Dashboard</span>
            </Link>
          </div>
          
          <div className="flex items-center space-x-4">
            {/* Search */}
            <div className="relative">
              {isSearchOpen ? (
                <motion.div
                  initial={{ width: 0, opacity: 0 }}
                  animate={{ width: '250px', opacity: 1 }}
                  exit={{ width: 0, opacity: 0 }}
                  transition={{ duration: 0.3 }}
                  className="flex items-center"
                >
                  <form onSubmit={handleSearch} className="w-full">
                    <input
                      type="text"
                      value={searchQuery}
                      onChange={(e) => setSearchQuery(e.target.value)}
                      placeholder="Search startups..."
                      className="w-full py-1.5 px-4 pr-10 rounded-full text-gray-900 focus:outline-none"
                      autoFocus
                    />
                  </form>
                  <button 
                    onClick={() => setIsSearchOpen(false)}
                    className="absolute right-2 text-gray-700"
                  >
                    <X className="h-5 w-5" />
                  </button>
                </motion.div>
              ) : (
                <button 
                  onClick={() => setIsSearchOpen(true)}
                  className="p-2 rounded-full hover:bg-indigo-500 hover:bg-opacity-50 focus:outline-none"
                >
                  <Search className="h-5 w-5" />
                </button>
              )}
            </div>
            
            {/* Notifications */}
            <div className="relative" ref={notificationRef}>
              <button
                onClick={() => setIsNotificationOpen(!isNotificationOpen)}
                className="p-2 rounded-full hover:bg-indigo-500 hover:bg-opacity-50 focus:outline-none relative"
              >
                <Bell className="h-5 w-5" />
                {notifications.filter(n => !n.read).length > 0 && (
                  <span className="absolute top-1 right-1 bg-red-500 rounded-full w-2 h-2"></span>
                )}
              </button>
              
              {isNotificationOpen && (
                <motion.div
                  initial={{ opacity: 0, y: -10 }}
                  animate={{ opacity: 1, y: 0 }}
                  exit={{ opacity: 0, y: -10 }}
                  transition={{ duration: 0.2 }}
                  className="absolute right-0 mt-2 w-80 bg-white backdrop-blur-md bg-opacity-90 rounded-lg shadow-xl py-2 text-gray-800 border border-gray-200/50 z-30"
                >
                  <div className="px-4 py-2 border-b border-gray-200">
                    <h3 className="text-sm font-semibold">Notifications</h3>
                  </div>
                  <div className="max-h-60 overflow-y-auto">
                    {notifications.length > 0 ? (
                      notifications.map(notification => (
                        <div 
                          key={notification.id} 
                          className={`px-4 py-3 hover:bg-gray-100 cursor-pointer ${!notification.read ? 'bg-blue-50' : ''}`}
                        >
                          <p className="text-sm font-medium">{notification.message}</p>
                          <p className="text-xs text-gray-500 mt-1">{notification.time}</p>
                          {!notification.read && (
                            <span className="inline-block w-2 h-2 bg-blue-500 rounded-full ml-1"></span>
                          )}
                        </div>
                      ))
                    ) : (
                      <p className="text-sm text-gray-500 px-4 py-3">No notifications</p>
                    )}
                  </div>
                  <div className="px-4 py-2 border-t border-gray-200">
                    <button className="text-xs text-indigo-600 hover:text-indigo-800 font-medium">
                      Mark all as read
                    </button>
                  </div>
                </motion.div>
              )}
            </div>
            
            {/* Profile dropdown */}
            <div className="relative" ref={profileRef}>
              <button
                onClick={() => setIsProfileOpen(!isProfileOpen)}
                className="flex items-center space-x-2 focus:outline-none"
              >
                <div className="h-8 w-8 rounded-full bg-indigo-300 flex items-center justify-center text-indigo-700 font-semibold">
                  {user?.name?.charAt(0) || 'U'}
                </div>
                <span className="hidden md:block text-sm font-medium">{user?.name || 'User'}</span>
                <ChevronDown className="h-4 w-4" />
              </button>
              
              {isProfileOpen && (
                <motion.div
                  initial={{ opacity: 0, y: -10 }}
                  animate={{ opacity: 1, y: 0 }}
                  exit={{ opacity: 0, y: -10 }}
                  transition={{ duration: 0.2 }}
                  className="absolute right-0 mt-2 w-48 bg-white backdrop-blur-md bg-opacity-90 rounded-lg shadow-xl py-1 z-30 border border-gray-200/50"
                >
                  <div className="px-4 py-2 border-b border-gray-200">
                    <p className="text-sm font-medium text-gray-900">{user?.name}</p>
                    <p className="text-xs text-gray-500">{user?.email}</p>
                  </div>
                  
                  <Link 
                    to="/settings" 
                    className="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                    onClick={() => setIsProfileOpen(false)}
                  >
                    <User className="h-4 w-4 mr-2" />
                    Your Profile
                  </Link>
                  
                  <Link 
                    to="/settings" 
                    className="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                    onClick={() => setIsProfileOpen(false)}
                  >
                    <Settings className="h-4 w-4 mr-2" />
                    Settings
                  </Link>
                  
                  {/* Theme selector */}
                  <div className="px-4 py-2 border-t border-gray-200">
                    <p className="text-xs font-medium text-gray-500 mb-1">Theme</p>
                    <div className="flex space-x-2">
                      <button 
                        onClick={() => toggleTheme('light')}
                        className={`p-1.5 rounded ${theme === 'light' ? 'bg-indigo-100 text-indigo-600' : 'text-gray-500 hover:bg-gray-100'}`}
                      >
                        <Sun className="h-4 w-4" />
                      </button>
                      <button 
                        onClick={() => toggleTheme('dark')}
                        className={`p-1.5 rounded ${theme === 'dark' ? 'bg-indigo-100 text-indigo-600' : 'text-gray-500 hover:bg-gray-100'}`}
                      >
                        <Moon className="h-4 w-4" />
                      </button>
                      <button 
                        onClick={() => toggleTheme('system')}
                        className={`p-1.5 rounded ${theme === 'system' ? 'bg-indigo-100 text-indigo-600' : 'text-gray-500 hover:bg-gray-100'}`}
                      >
                        <Laptop className="h-4 w-4" />
                      </button>
                    </div>
                  </div>
                  
                  <button 
                    onClick={handleLogout}
                    className="flex w-full items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 border-t border-gray-200"
                  >
                    <LogOut className="h-4 w-4 mr-2" />
                    Sign out
                  </button>
                </motion.div>
              )}
            </div>
          </div>
        </div>
      </div>
    </nav>
  );
};

export default Navbar;
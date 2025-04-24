import React from 'react';
import { Link } from 'react-router-dom';
import { motion } from 'framer-motion';
import { LogIn, UserPlus, BarChart3 } from 'lucide-react';

const AuthLayout = ({ children }) => {
  // Animation variants for the auth forms
  const containerVariants = {
    hidden: { opacity: 0 },
    visible: { 
      opacity: 1,
      transition: { 
        duration: 0.5,
        when: "beforeChildren",
        staggerChildren: 0.2
      }
    }
  };

  const itemVariants = {
    hidden: { y: 20, opacity: 0 },
    visible: { 
      y: 0, 
      opacity: 1,
      transition: { duration: 0.5, ease: "easeOut" }
    }
  };

  return (
    <div className="min-h-screen flex flex-col">
      {/* Header */}
      <header className="bg-gradient-to-r from-indigo-600 to-purple-600 shadow-md">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
          <div className="flex justify-between items-center">
            <Link to="/" className="flex items-center">
              <BarChart3 className="h-8 w-8 text-white" />
              <span className="ml-2 text-xl font-bold text-white">Startup India Dashboard</span>
            </Link>
            <div className="flex space-x-4">
              <Link to="/login" className="flex items-center text-white hover:text-indigo-100 transition-colors">
                <LogIn className="h-5 w-5 mr-1" />
                <span>Login</span>
              </Link>
              <Link to="/register" className="flex items-center text-white hover:text-indigo-100 transition-colors">
                <UserPlus className="h-5 w-5 mr-1" />
                <span>Register</span>
              </Link>
            </div>
          </div>
        </div>
      </header>

      {/* Main Content */}
      <main className="flex-1 bg-gray-100">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
          <motion.div 
            className="flex justify-center items-center min-h-[calc(100vh-120px)]"
            variants={containerVariants}
            initial="hidden"
            animate="visible"
          >
            <motion.div
              className="w-full max-w-md"
              variants={itemVariants}
            >
              {/* Glass morphism card */}
              <div className="backdrop-blur-md bg-white/80 rounded-lg shadow-xl overflow-hidden border border-gray-200/50">
                {children}
              </div>
            </motion.div>
          </motion.div>
        </div>
      </main>

      {/* Footer */}
      <footer className="bg-gray-800 text-white py-6">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="text-center">
            <p>© 2025 Startup India Dashboard. All rights reserved.</p>
          </div>
        </div>
      </footer>
    </div>
  );
};

export default AuthLayout;
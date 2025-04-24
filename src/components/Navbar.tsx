import React from 'react';
import { Menu } from 'lucide-react';

interface NavbarProps {
  toggleSidebar: () => void;
}

const Navbar: React.FC<NavbarProps> = ({ toggleSidebar }) => {
  return (
    <nav className="bg-white border-b border-gray-200/50 px-4 py-2.5 fixed left-0 right-0 top-0 z-50">
      <div className="flex justify-between items-center">
        <div className="flex items-center">
          <button
            onClick={toggleSidebar}
            className="p-2 rounded-lg text-gray-600 hover:bg-gray-100"
          >
            <Menu className="h-6 w-6" />
          </button>
          <span className="ml-4 text-xl font-semibold text-gray-900">Startup India</span>
        </div>
        
        <div className="flex items-center gap-4">
          <button className="text-gray-600 hover:text-gray-900">
            <img
              src="https://images.pexels.com/photos/2381069/pexels-photo-2381069.jpeg?auto=compress&cs=tinysrgb&w=32&h=32&dpr=2"
              alt="Profile"
              className="w-8 h-8 rounded-full"
            />
          </button>
        </div>
      </div>
    </nav>
  );
};

export default Navbar;
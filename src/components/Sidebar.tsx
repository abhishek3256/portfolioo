import React from 'react';
import { Link } from 'react-router-dom';
import {
  LayoutDashboard,
  Building2,
  Users,
  Target,
  Settings,
  HelpCircle
} from 'lucide-react';

interface SidebarProps {
  isOpen: boolean;
}

const Sidebar: React.FC<SidebarProps> = ({ isOpen }) => {
  const menuItems = [
    { icon: <LayoutDashboard size={20} />, label: 'Dashboard', path: '/' },
    { icon: <Building2 size={20} />, label: 'Startups', path: '/startups' },
    { icon: <Users size={20} />, label: 'Investors', path: '/investors' },
    { icon: <Target size={20} />, label: 'Milestones', path: '/milestones' },
  ];

  const bottomMenuItems = [
    { icon: <Settings size={20} />, label: 'Settings', path: '/settings' },
    { icon: <HelpCircle size={20} />, label: 'Help', path: '/help' },
  ];

  return (
    <aside
      className={`fixed left-0 top-0 z-40 h-screen pt-16 transition-transform ${
        isOpen ? 'translate-x-0' : '-translate-x-full'
      } bg-white border-r border-gray-200/50 w-64`}
    >
      <div className="h-full px-3 py-4 flex flex-col justify-between">
        <div>
          <ul className="space-y-2">
            {menuItems.map((item, index) => (
              <li key={index}>
                <Link
                  to={item.path}
                  className="flex items-center p-2 text-gray-600 rounded-lg hover:bg-gray-100 group"
                >
                  <span className="text-gray-500 group-hover:text-indigo-600">
                    {item.icon}
                  </span>
                  <span className="ml-3 group-hover:text-gray-900">{item.label}</span>
                </Link>
              </li>
            ))}
          </ul>
        </div>
        
        <div>
          <ul className="space-y-2">
            {bottomMenuItems.map((item, index) => (
              <li key={index}>
                <Link
                  to={item.path}
                  className="flex items-center p-2 text-gray-600 rounded-lg hover:bg-gray-100 group"
                >
                  <span className="text-gray-500 group-hover:text-indigo-600">
                    {item.icon}
                  </span>
                  <span className="ml-3 group-hover:text-gray-900">{item.label}</span>
                </Link>
              </li>
            ))}
          </ul>
        </div>
      </div>
    </aside>
  );
};

export default Sidebar;
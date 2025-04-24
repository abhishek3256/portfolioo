import React from 'react';
import { motion } from 'framer-motion';
import {
  TrendingUp, Users, Building2, Briefcase, ArrowUpRight,
  DollarSign, Target, Award, Activity
} from 'lucide-react';

const Dashboard = () => {
  // Mock data for dashboard
  const stats = [
    {
      title: 'Total Startups',
      value: '3,721',
      change: '+12.5%',
      trend: 'up',
      icon: <Building2 className="h-6 w-6 text-blue-600" />
    },
    {
      title: 'Total Funding',
      value: '₹8.2B',
      change: '+28.4%',
      trend: 'up',
      icon: <DollarSign className="h-6 w-6 text-green-600" />
    },
    {
      title: 'Active Investors',
      value: '892',
      change: '+5.2%',
      trend: 'up',
      icon: <Briefcase className="h-6 w-6 text-purple-600" />
    },
    {
      title: 'Success Rate',
      value: '68%',
      change: '+3.1%',
      trend: 'up',
      icon: <Target className="h-6 w-6 text-orange-600" />
    }
  ];

  const recentStartups = [
    {
      name: 'EcoTech Solutions',
      industry: 'CleanTech',
      funding: '₹2.5M',
      status: 'active'
    },
    {
      name: 'HealthConnect',
      industry: 'HealthTech',
      funding: '₹4.2M',
      status: 'active'
    },
    {
      name: 'FinEdge',
      industry: 'FinTech',
      funding: '₹3.8M',
      status: 'active'
    }
  ];

  const upcomingMilestones = [
    {
      startup: 'EcoTech Solutions',
      milestone: 'Product Launch',
      date: '2024-03-15'
    },
    {
      startup: 'HealthConnect',
      milestone: 'Series A Funding',
      date: '2024-03-20'
    },
    {
      startup: 'FinEdge',
      milestone: 'Market Expansion',
      date: '2024-03-25'
    }
  ];

  return (
    <div className="space-y-6">
      {/* Header */}
      <div className="flex justify-between items-center">
        <div>
          <h1 className="text-2xl font-bold text-gray-900">Dashboard</h1>
          <p className="text-gray-600">Monitor and track startup progress</p>
        </div>
        <button className="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition-colors">
          Add Startup
        </button>
      </div>

      {/* Stats Grid */}
      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        {stats.map((stat, index) => (
          <motion.div
            key={index}
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ delay: index * 0.1 }}
            className="bg-white/80 backdrop-blur-md rounded-xl border border-gray-200/50 p-6 shadow-sm"
          >
            <div className="flex items-center justify-between">
              <div className="bg-gray-100/80 p-3 rounded-lg">{stat.icon}</div>
              {stat.trend === 'up' && (
                <span className="flex items-center text-green-600 text-sm">
                  <ArrowUpRight className="h-4 w-4 mr-1" />
                  {stat.change}
                </span>
              )}
            </div>
            <div className="mt-4">
              <h3 className="text-gray-600 text-sm font-medium">{stat.title}</h3>
              <p className="text-2xl font-bold text-gray-900 mt-1">{stat.value}</p>
            </div>
          </motion.div>
        ))}
      </div>

      {/* Main Content Grid */}
      <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {/* Recent Startups */}
        <motion.div
          initial={{ opacity: 0, x: -20 }}
          animate={{ opacity: 1, x: 0 }}
          className="bg-white/80 backdrop-blur-md rounded-xl border border-gray-200/50 p-6 shadow-sm"
        >
          <div className="flex items-center justify-between mb-6">
            <h2 className="text-lg font-semibold text-gray-900">Recent Startups</h2>
            <button className="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
              View All
            </button>
          </div>
          <div className="space-y-4">
            {recentStartups.map((startup, index) => (
              <div key={index} className="flex items-center justify-between p-4 bg-gray-50/50 rounded-lg">
                <div className="flex items-center space-x-4">
                  <div className="bg-indigo-100 p-2 rounded-lg">
                    <Building2 className="h-5 w-5 text-indigo-600" />
                  </div>
                  <div>
                    <h3 className="font-medium text-gray-900">{startup.name}</h3>
                    <p className="text-sm text-gray-600">{startup.industry}</p>
                  </div>
                </div>
                <div className="text-right">
                  <p className="font-medium text-gray-900">{startup.funding}</p>
                  <span className="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                    {startup.status}
                  </span>
                </div>
              </div>
            ))}
          </div>
        </motion.div>

        {/* Upcoming Milestones */}
        <motion.div
          initial={{ opacity: 0, x: 20 }}
          animate={{ opacity: 1, x: 0 }}
          className="bg-white/80 backdrop-blur-md rounded-xl border border-gray-200/50 p-6 shadow-sm"
        >
          <div className="flex items-center justify-between mb-6">
            <h2 className="text-lg font-semibold text-gray-900">Upcoming Milestones</h2>
            <button className="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
              View Calendar
            </button>
          </div>
          <div className="space-y-4">
            {upcomingMilestones.map((milestone, index) => (
              <div key={index} className="flex items-center justify-between p-4 bg-gray-50/50 rounded-lg">
                <div className="flex items-center space-x-4">
                  <div className="bg-purple-100 p-2 rounded-lg">
                    <Award className="h-5 w-5 text-purple-600" />
                  </div>
                  <div>
                    <h3 className="font-medium text-gray-900">{milestone.startup}</h3>
                    <p className="text-sm text-gray-600">{milestone.milestone}</p>
                  </div>
                </div>
                <div>
                  <p className="text-sm font-medium text-gray-900">
                    {new Date(milestone.date).toLocaleDateString('en-US', {
                      month: 'short',
                      day: 'numeric'
                    })}
                  </p>
                </div>
              </div>
            ))}
          </div>
        </motion.div>
      </div>
    </div>
  );
};

export default Dashboard;
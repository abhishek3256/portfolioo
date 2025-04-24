import React, { createContext, useContext, useState, useEffect } from 'react';
import axios from 'axios';

const AuthContext = createContext();

export const useAuth = () => useContext(AuthContext);

export const AuthProvider = ({ children }) => {
  const [user, setUser] = useState(null);
  const [isAuthenticated, setIsAuthenticated] = useState(false);
  const [isLoading, setIsLoading] = useState(true);
  const [error, setError] = useState(null);

  const loadUser = async () => {
    setIsLoading(true);
    const token = localStorage.getItem('token');
    
    if (!token) {
      setIsAuthenticated(false);
      setUser(null);
      setIsLoading(false);
      return;
    }
    
    try {
      const res = await axios.get('/api/user', {
        headers: {
          Authorization: `Bearer ${token}`
        }
      });
      
      if (res.data.status === 'success') {
        setUser(res.data.user);
        setIsAuthenticated(true);
      } else {
        localStorage.removeItem('token');
        setIsAuthenticated(false);
        setUser(null);
      }
    } catch (err) {
      console.error('Error loading user:', err);
      localStorage.removeItem('token');
      setIsAuthenticated(false);
      setUser(null);
    }
    
    setIsLoading(false);
  };

  const login = async (email, password) => {
    setError(null);
    setIsLoading(true);
    
    try {
      const res = await axios.post('/api/login', { email, password });
      
      if (res.data.status === 'success') {
        localStorage.setItem('token', res.data.token);
        setUser(res.data.user);
        setIsAuthenticated(true);
        setIsLoading(false);
        return true;
      } else {
        setError(res.data.message || 'Login failed');
        setIsLoading(false);
        return false;
      }
    } catch (err) {
      setError(err.response?.data?.message || 'Login failed');
      setIsLoading(false);
      return false;
    }
  };

  const register = async (name, email, password, password_confirmation) => {
    setError(null);
    setIsLoading(true);
    
    try {
      const res = await axios.post('/api/register', {
        name,
        email,
        password,
        password_confirmation
      });
      
      if (res.data.status === 'success') {
        localStorage.setItem('token', res.data.token);
        setUser(res.data.user);
        setIsAuthenticated(true);
        setIsLoading(false);
        return true;
      } else {
        setError(res.data.message || 'Registration failed');
        setIsLoading(false);
        return false;
      }
    } catch (err) {
      setError(err.response?.data?.message || 'Registration failed');
      setIsLoading(false);
      return false;
    }
  };

  const logout = async () => {
    setIsLoading(true);
    const token = localStorage.getItem('token');
    
    if (token) {
      try {
        await axios.post('/api/logout', {}, {
          headers: {
            Authorization: `Bearer ${token}`
          }
        });
      } catch (err) {
        console.error('Error during logout:', err);
      }
    }
    
    localStorage.removeItem('token');
    setUser(null);
    setIsAuthenticated(false);
    setIsLoading(false);
  };

  // Set axios default headers
  useEffect(() => {
    const token = localStorage.getItem('token');
    if (token) {
      axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
    } else {
      delete axios.defaults.headers.common['Authorization'];
    }
  }, [isAuthenticated]);

  const value = {
    user,
    isAuthenticated,
    isLoading,
    error,
    login,
    register,
    logout,
    loadUser
  };

  return <AuthContext.Provider value={value}>{children}</AuthContext.Provider>;
};
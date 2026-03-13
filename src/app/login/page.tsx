"use client";
import React, { useState } from 'react';
import { motion } from 'framer-motion';
import { User, Lock, ArrowLeft } from 'lucide-react';
import { useRouter } from 'next/navigation';
import Link from 'next/link';

export default function LoginPage() {
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const router = useRouter();

  const handleLogin = async (e: React.FormEvent) => {
    e.preventDefault();
    try {
      const response = await fetch('/api/login', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ email, password }),
      });

      const data = await response.json();

      if (response.ok) {
        // Store user info in localStorage for the whole app to use
        localStorage.setItem('user_name', data.user.name || 'User');
        localStorage.setItem('user_email', data.user.email);
        
        // Redirect based on role
        if (data.user.role === 'admin') {
          router.push('/admin/products');
        } else {
          router.push('/dashboard');
        }
      } else {
        alert(data.error || 'Login failed');
      }
    } catch (err) {
      console.error(err);
      alert('An error occurred during login.');
    }
  };

  return (
    <div className="min-h-screen w-full flex items-center justify-center bg-[#2D1B14] p-4 md:p-8">
      {/* Main Container */}
      <motion.div 
        initial={{ opacity: 0, scale: 0.98 }}
        animate={{ opacity: 1, scale: 1 }}
        className="w-full max-w-5xl bg-white rounded-[2.5rem] overflow-hidden shadow-[0_50px_100px_-20px_rgba(0,0,0,0.6)] flex flex-col md:flex-row min-h-[600px]"
      >
        {/* Left Side: Dark Info & Image */}
        <div className="w-full md:w-[45%] bg-[#1A110D] relative overflow-hidden flex flex-col justify-center p-12 text-white">
          {/* Coffee Image Overlay */}
          <div className="absolute inset-0 z-0">
            <img 
              src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?q=80&w=1200&auto=format&fit=crop" 
              alt="Coffee Background"
              className="w-full h-full object-cover opacity-40"
            />
            <div className="absolute inset-0 bg-gradient-to-t from-[#1A110D] via-transparent to-transparent"></div>
          </div>

          <div className="relative z-10">
            {/* Logo */}
            <div className="mb-8">
              <img src="/images/logo.png" alt="NextCafe" className="w-40 h-auto drop-shadow-2xl" />
            </div>

            <h2 className="text-5xl font-black mb-6 leading-tight tracking-tight">
              Welcome to website
            </h2>
            
            <p className="text-cream-100/70 text-lg leading-relaxed font-medium max-w-sm">
              NextCafe brings you the finest beans and crafting every cup with passion. Login to explore our premium collection.
            </p>
          </div>
        </div>

        {/* Right Side: White Login Form */}
        <div className="w-full md:w-[55%] bg-white p-12 md:p-20 flex flex-col justify-center">
          <div className="max-w-md mx-auto w-full">
            <h3 className="text-2xl font-black text-coffee-950 mb-10 uppercase tracking-widest">
              USER LOGIN
            </h3>

            <form onSubmit={handleLogin} className="space-y-8">
              {/* Email Field */}
              <div className="space-y-3">
                <div className="flex items-center space-x-2 text-coffee-400">
                  <User className="h-5 w-5" />
                </div>
                <input 
                  type="email" 
                  required
                  placeholder="Email Address"
                  value={email}
                  onChange={(e) => setEmail(e.target.value)}
                  className="w-full bg-white border border-coffee-100 rounded-xl py-4 px-6 text-coffee-950 outline-none focus:border-[#D4A373] focus:ring-4 focus:ring-[#D4A373]/5 transition-all placeholder:text-coffee-200"
                />
              </div>

              {/* Password Field */}
              <div className="space-y-3">
                <div className="flex items-center space-x-2 text-coffee-400">
                  <Lock className="h-5 w-5" />
                </div>
                <input 
                  type="password" 
                  required
                  placeholder="Password"
                  value={password}
                  onChange={(e) => setPassword(e.target.value)}
                  className="w-full bg-white border border-coffee-100 rounded-xl py-4 px-6 text-coffee-950 outline-none focus:border-[#D4A373] focus:ring-4 focus:ring-[#D4A373]/5 transition-all placeholder:text-coffee-200"
                />
              </div>

              {/* Remember & Forgot */}
              <div className="flex items-center justify-between text-sm">
                <label className="flex items-center text-coffee-400 cursor-pointer hover:text-coffee-600 transition-colors font-medium">
                  <input type="checkbox" className="mr-2 rounded accent-[#D4A373] border-coffee-100" />
                  Remember
                </label>
                <a href="#" className="text-coffee-400 hover:text-coffee-900 font-medium transition-colors">
                  Forgot password?
                </a>
              </div>

              {/* Login Button */}
              <button 
                type="submit"
                className="w-full bg-[#D4A373] text-white py-5 rounded-xl font-black text-lg uppercase tracking-widest hover:bg-[#b68a5d] transition-all shadow-xl shadow-[#D4A373]/20 active:scale-[0.98]"
              >
                LOGIN
              </button>
            </form>

            <div className="mt-10 flex flex-col space-y-6">
              <p className="text-coffee-950 font-medium">
                Don't have account? <Link href="/register" className="text-[#6366F1] font-bold hover:underline">Register Now</Link>
              </p>
            </div>
          </div>
        </div>
      </motion.div>
    </div>
  );
}

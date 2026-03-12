"use client";
import React, { useState } from 'react';
import { motion } from 'framer-motion';
import { User, Mail, Lock, ArrowLeft, Coffee } from 'lucide-react';
import { useRouter } from 'next/navigation';
import Link from 'next/link';

export default function RegisterPage() {
  const [name, setName] = useState('');
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [confirmPassword, setConfirmPassword] = useState('');
  const router = useRouter();

  const handleRegister = async (e: React.FormEvent) => {
    e.preventDefault();
    try {
      const response = await fetch('/api/register', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ name, email, password }),
      });

      if (response.ok) {
        // Store name locally for now to show on profile
        localStorage.setItem('user_name', name);
        localStorage.setItem('user_email', email);
        router.push('/login');
      } else {
        alert('Registration failed. Please try again.');
      }
    } catch (err) {
      console.error(err);
      alert('An error occurred.');
    }
  };

  return (
    <div className="min-h-screen w-full flex items-center justify-center bg-[#2D1B14] p-4 md:p-8">
      {/* Main Container */}
      <motion.div 
        initial={{ opacity: 0, y: 20 }}
        animate={{ opacity: 1, y: 0 }}
        className="w-full max-w-5xl bg-white rounded-[2.5rem] overflow-hidden shadow-[0_50px_100px_-20px_rgba(0,0,0,0.6)] flex flex-col md:flex-row min-h-[650px]"
      >
        {/* Left Side: Brand Image & Promo */}
        <div className="w-full md:w-[45%] bg-[#1A110D] relative overflow-hidden flex flex-col justify-center p-12 text-white">
          <div className="absolute inset-0 z-0">
            <img 
              src="https://images.unsplash.com/photo-1497933322477-911b366be807?q=80&w=1200&auto=format&fit=crop" 
              alt="Coffee Beans"
              className="w-full h-full object-cover opacity-50"
            />
            <div className="absolute inset-0 bg-gradient-to-br from-[#2D1B14] to-transparent"></div>
          </div>

          <div className="relative z-10">
            <img src="/images/logo.png" alt="NextCafe" className="w-40 h-auto mb-10 drop-shadow-2xl" />
            <h2 className="text-5xl font-black mb-6 leading-tight tracking-tight">
              Create an account
            </h2>
            <p className="text-cream-100/70 text-lg leading-relaxed font-medium max-w-sm">
              Join NextCafe today and start earning rewards for every cup you enjoy. Experience coffee like never before.
            </p>
            
            <div className="mt-12 flex items-center space-x-4">
               <div className="w-12 h-12 rounded-full border border-white/20 flex items-center justify-center">
                 <Coffee className="h-5 w-5 text-[#D4A373]" />
               </div>
               <span className="text-sm font-bold uppercase tracking-widest text-[#D4A373]">Premium Quality Guaranteed</span>
            </div>
          </div>
        </div>

        {/* Right Side: Register Form */}
        <div className="w-full md:w-[55%] bg-white p-12 md:p-16 flex flex-col justify-center">
          <div className="max-w-md mx-auto w-full">
            <h3 className="text-2xl font-black text-coffee-950 mb-8 uppercase tracking-widest">
              USER REGISTRATION
            </h3>

            <form onSubmit={handleRegister} className="space-y-6">
              {/* Full Name */}
              <div className="space-y-2">
                <div className="flex items-center space-x-2 text-coffee-400">
                  <User className="h-4 w-4" />
                  <span className="text-[10px] font-black uppercase tracking-widest">Full Name</span>
                </div>
                <input 
                  type="text" 
                  required
                  placeholder="John Doe"
                  className="w-full bg-white border border-coffee-100 rounded-xl py-4 px-6 text-coffee-950 outline-none focus:border-[#D4A373] focus:ring-4 focus:ring-[#D4A373]/5 transition-all"
                  value={name}
                  onChange={(e) => setName(e.target.value)}
                />
              </div>

              {/* Email Address */}
              <div className="space-y-2">
                <div className="flex items-center space-x-2 text-coffee-400">
                  <Mail className="h-4 w-4" />
                  <span className="text-[10px] font-black uppercase tracking-widest">Email Address</span>
                </div>
                <input 
                  type="email" 
                  required
                  placeholder="hello@example.com"
                  className="w-full bg-white border border-coffee-100 rounded-xl py-4 px-6 text-coffee-950 outline-none focus:border-[#D4A373] focus:ring-4 focus:ring-[#D4A373]/5 transition-all"
                  value={email}
                  onChange={(e) => setEmail(e.target.value)}
                />
              </div>

              {/* Password Group */}
              <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div className="space-y-2">
                  <div className="flex items-center space-x-2 text-coffee-400">
                    <Lock className="h-4 w-4" />
                    <span className="text-[10px] font-black uppercase tracking-widest">Password</span>
                  </div>
                  <input 
                    type="password" 
                    required
                    placeholder="••••••••"
                    className="w-full bg-white border border-coffee-100 rounded-xl py-4 px-6 text-coffee-950 outline-none focus:border-[#D4A373] focus:ring-4 focus:ring-[#D4A373]/5 transition-all"
                    value={password}
                    onChange={(e) => setPassword(e.target.value)}
                  />
                </div>
                <div className="space-y-2">
                  <div className="flex items-center space-x-2 text-coffee-400">
                    <Lock className="h-4 w-4" />
                    <span className="text-[10px] font-black uppercase tracking-widest">Confirm</span>
                  </div>
                  <input 
                    type="password" 
                    required
                    placeholder="••••••••"
                    className="w-full bg-white border border-coffee-100 rounded-xl py-4 px-6 text-coffee-950 outline-none focus:border-[#D4A373] focus:ring-4 focus:ring-[#D4A373]/5 transition-all"
                    value={confirmPassword}
                    onChange={(e) => setConfirmPassword(e.target.value)}
                  />
                </div>
              </div>

              <div className="flex items-center text-xs text-coffee-400 font-medium">
                <input type="checkbox" required className="mr-3 h-4 w-4 rounded accent-[#D4A373] border-coffee-100" />
                <span>I agree to the <a href="#" className="underline font-bold text-coffee-900">Terms and Conditions</a></span>
              </div>

              {/* Action Button */}
              <button 
                type="submit"
                className="w-full bg-coffee-950 text-white py-5 rounded-xl font-black text-lg uppercase tracking-widest hover:bg-[#D4A373] transition-all shadow-xl active:scale-[0.98]"
              >
                CREATE ACCOUNT
              </button>
            </form>

            <div className="mt-8 flex flex-col space-y-6">
              <p className="text-coffee-950 font-medium">
                Already have an account? <Link href="/login" className="text-[#6366F1] font-bold hover:underline">Login Now</Link>
              </p>
            </div>
          </div>
        </div>
      </motion.div>
    </div>
  );
}

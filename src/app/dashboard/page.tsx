"use client";
import React, { useEffect, useState } from 'react';
import { Coffee, ShoppingBag, Star, TrendingUp } from 'lucide-react';
import { motion } from 'framer-motion';
import Link from 'next/link';

export default function CustomerDashboard() {
  const [userName, setUserName] = useState('Valued Member');

  useEffect(() => {
    const name = localStorage.getItem('user_name');
    if (name) setUserName(name);
  }, []);

  const stats = [
    { title: 'Total Orders', value: '0', icon: ShoppingBag, color: 'bg-blue-500' },
    { title: 'Points Earned', value: '0', icon: Star, color: 'bg-yellow-500' },
    { title: 'Favorite Drink', value: 'None yet', icon: Coffee, color: 'bg-orange-500' },
  ];

  return (
    <div className="max-w-6xl mx-auto py-8">
      {/* Welcome Header */}
      <motion.div 
        initial={{ opacity: 0, y: -20 }}
        animate={{ opacity: 1, y: 0 }}
        className="mb-12"
      >
        <h1 className="text-4xl font-black text-coffee-950">Welcome back, {userName}! ☕</h1>
        <p className="text-coffee-500 text-lg mt-2 font-medium">It's a beautiful day for a fresh cup of coffee.</p>
      </motion.div>

      {/* Stats Grid */}
      <div className="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
        {stats.map((stat, idx) => (
          <motion.div 
            initial={{ opacity: 0, scale: 0.9 }}
            animate={{ opacity: 1, scale: 1 }}
            transition={{ delay: idx * 0.1 }}
            key={stat.title}
            className="bg-white p-8 rounded-[2.5rem] border border-coffee-50 shadow-sm hover:shadow-xl transition-all"
          >
            <div className={`${stat.color} w-14 h-14 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-${stat.color.split('-')[1]}-200`}>
              <stat.icon className="text-white h-7 w-7" />
            </div>
            <h3 className="text-coffee-400 font-black uppercase tracking-widest text-[10px] mb-2">{stat.title}</h3>
            <p className="text-3xl font-black text-coffee-950">{stat.value}</p>
          </motion.div>
        ))}
      </div>

      {/* Quick Actions / Promotion */}
      <div className="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div className="bg-[#2D1B14] rounded-[3rem] p-10 text-white relative overflow-hidden h-[300px] flex flex-col justify-center">
           <div className="relative z-10">
             <h2 className="text-3xl font-black mb-4">New Seasonal Drinks are here!</h2>
             <p className="text-cream-100/70 mb-8 max-w-sm">Try our limited edition Pumpkin Spice and Toffee Nut lattes today.</p>
             <Link href="/menu" className="inline-block bg-[#D4A373] text-white px-8 py-4 rounded-2xl font-black hover:scale-105 transition-all shadow-xl shadow-[#D4A373]/20">
                Order Now
             </Link>
           </div>
           <Coffee className="absolute -right-10 -bottom-10 h-64 w-64 text-white/5 rotate-12" />
        </div>

        <div className="bg-white rounded-[3rem] p-10 border border-coffee-50 flex flex-col justify-center h-[300px]">
           <div className="flex items-center space-x-4 mb-6">
              <div className="p-3 bg-green-50 rounded-xl">
                 <TrendingUp className="text-green-600 h-6 w-6" />
              </div>
              <h2 className="text-2xl font-black text-coffee-950">Earning Progress</h2>
           </div>
           <div className="w-full bg-cream-50 h-4 rounded-full overflow-hidden mb-4">
              <div className="bg-[#C69276] h-full w-[0%] rounded-full shadow-lg shadow-[#C69276]/30"></div>
           </div>
           <p className="text-coffee-500 font-medium">You need <span className="text-[#C69276] font-bold">500 points</span> for your next free drink!</p>
        </div>
      </div>
    </div>
  );
}

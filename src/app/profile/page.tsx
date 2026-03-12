"use client";
import React from 'react';
import { User, Mail, MapPin, Camera, Save } from 'lucide-react';
import { motion } from 'framer-motion';

export default function ProfilePage() {
  const [userName, setUserName] = React.useState('NextCafe Member');
  const [userEmail, setUserEmail] = React.useState('hello@nextcafe.com');

  React.useEffect(() => {
    const storedName = localStorage.getItem('user_name');
    const storedEmail = localStorage.getItem('user_email');
    if (storedName) setUserName(storedName);
    if (storedEmail) setUserEmail(storedEmail);
  }, []);

  return (
    <div className="max-w-4xl mx-auto py-12">
      <h1 className="text-4xl font-black text-coffee-950 mb-12">My Profile</h1>

      <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
        {/* Left: Avatar Upload */}
        <div className="col-span-1 bg-white p-8 rounded-[2.5rem] border border-coffee-50 shadow-sm flex flex-col items-center">
          <div className="relative group">
            <div className="w-32 h-32 bg-cream-50 rounded-full flex items-center justify-center overflow-hidden border-4 border-white shadow-xl">
               <User className="h-16 w-16 text-coffee-200" />
            </div>
            <button className="absolute bottom-0 right-0 bg-[#C69276] p-3 rounded-full text-white shadow-lg hover:scale-110 transition-all">
              <Camera className="h-4 w-4" />
            </button>
          </div>
          <h2 className="mt-6 text-xl font-bold text-coffee-950 text-center">{userName}</h2>
          <p className="text-coffee-400 font-medium text-sm">Member since 2026</p>
        </div>

        {/* Right: Profile Info */}
        <div className="col-span-2 bg-white p-10 rounded-[2.5rem] border border-coffee-50 shadow-sm">
          <form className="space-y-6">
            <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div className="space-y-2">
                <label className="text-xs font-black text-coffee-300 uppercase tracking-widest px-1">Full Name</label>
                <div className="relative">
                  <User className="absolute left-4 top-1/2 -translate-y-1/2 h-4 w-4 text-coffee-200" />
                  <input type="text" placeholder={userName} className="w-full bg-cream-50/30 border border-coffee-50 rounded-2xl py-4 pl-12 pr-6 outline-none focus:ring-4 focus:ring-[#C69276]/10" />
                </div>
              </div>
              <div className="space-y-2">
                <label className="text-xs font-black text-coffee-300 uppercase tracking-widest px-1">Email Address</label>
                <div className="relative">
                  <Mail className="absolute left-4 top-1/2 -translate-y-1/2 h-4 w-4 text-coffee-200" />
                  <input type="email" placeholder={userEmail} className="w-full bg-cream-50/30 border border-coffee-50 rounded-2xl py-4 pl-12 pr-6 outline-none focus:ring-4 focus:ring-[#C69276]/10" />
                </div>
              </div>
            </div>

            <div className="space-y-2">
               <label className="text-xs font-black text-coffee-300 uppercase tracking-widest px-1">Shipping Address</label>
               <div className="relative">
                 <MapPin className="absolute left-4 top-4 h-4 w-4 text-coffee-200" />
                 <textarea rows={3} placeholder="123 Coffee Lane, Barista City" className="w-full bg-cream-50/30 border border-coffee-50 rounded-2xl py-4 pl-12 pr-6 outline-none focus:ring-4 focus:ring-[#C69276]/10"></textarea>
               </div>
            </div>

            <button className="bg-[#C69276] text-white px-10 py-4 rounded-2xl font-black flex items-center space-x-3 hover:scale-105 transition-all shadow-xl shadow-[#C69276]/20">
              <Save className="h-5 w-5" />
              <span>Save Changes</span>
            </button>
          </form>
        </div>
      </div>
    </div>
  );
}

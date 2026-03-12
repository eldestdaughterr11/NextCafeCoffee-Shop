"use client";
import Link from 'next/link';
import { usePathname, useRouter } from 'next/navigation';
import { 
  LayoutDashboard, 
  Coffee, 
  ShoppingBag, 
  ShoppingCart, 
  Info, 
  Mail, 
  User,
  LogOut
} from 'lucide-react';
import { motion } from 'framer-motion';

export default function CustomerSidebar() {
  const pathname = usePathname();
  const router = useRouter();

  const handleLogout = () => {
    router.push('/login');
  };

  const menuItems = [
    { title: 'Dashboard', icon: LayoutDashboard, href: '/dashboard' },
    { title: 'Menu', icon: Coffee, href: '/menu' },
    { title: 'My Orders', icon: ShoppingBag, href: '/orders' },
    { title: 'Shopping Cart', icon: ShoppingCart, href: '/cart' },
    { title: 'About Us', icon: Info, href: '/about' },
    { title: 'Contact Us', icon: Mail, href: '/contact' },
    { title: 'My Profile', icon: User, href: '/profile' },
  ];

  return (
    <div className="w-72 bg-[#2D1B14] text-white min-h-screen p-6 flex flex-col fixed left-0 top-0 shadow-2xl z-50">
      <div className="flex flex-col items-center mb-12 mt-4">
        <div className="w-40 h-40 flex items-center justify-center overflow-hidden p-1">
           <img src="/images/logo.png" alt="NextCafe Logo" className="w-full h-auto drop-shadow-2xl" />
        </div>
      </div>

      {/* Navigation Links */}
      <nav className="flex-grow space-y-2">
        {menuItems.map((item) => {
          const isActive = pathname === item.href;
          return (
            <Link 
              key={item.title}
              href={item.href}
              className={`flex items-center space-x-4 p-4 rounded-xl transition-all font-medium group ${
                isActive 
                ? 'bg-[#C69276] text-white shadow-lg shadow-[#C69276]/20' 
                : 'text-cream-100/60 hover:bg-white/5 hover:text-white'
              }`}
            >
              <item.icon className={`h-5 w-5 ${isActive ? 'text-white' : 'text-cream-100/40 group-hover:text-white'}`} />
              <span className="text-sm">{item.title}</span>
            </Link>
          );
        })}
      </nav>

      {/* Footer / Logout */}
      <div className="pt-6 border-t border-white/5">
        <button 
          onClick={handleLogout}
          className="w-full flex items-center space-x-4 p-4 rounded-xl text-red-300 hover:bg-red-500/10 transition-all font-bold"
        >
          <LogOut className="h-5 w-5" />
          <span className="text-sm">Logout</span>
        </button>
      </div>
    </div>
  );
}
